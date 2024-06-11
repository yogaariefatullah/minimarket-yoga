<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga produk dan id produk dari penjualan
    $stmt = $pdo->prepare("SELECT produk_id, (SELECT harga FROM produk WHERE id = penjualan.produk_id) as harga, (SELECT jumlah FROM penjualan WHERE id = ?) as jumlah_penjualan FROM penjualan WHERE id = ?");
    $stmt->execute([$id, $id]);
    $penjualan = $stmt->fetch();

    if ($penjualan) {
        // Hitung stok saat ini setelah pengurangan penjualan yang lama dan penambahan penjualan yang baru
        $stok_sekarang = $penjualan['jumlah_penjualan'] + (int)$penjualan['jumlah'] - (int)$jumlah;

        // Ambil stok saat ini dari produk
        $stmt_stok = $pdo->prepare("SELECT stok FROM produk WHERE id = ?");
        $stmt_stok->execute([$penjualan['produk_id']]);
        $produk = $stmt_stok->fetch();

        if ($produk && $stok_sekarang <= $produk['stok']) {
            $total = $penjualan['harga'] * $jumlah;

            // Update penjualan
            $stmt_update_penjualan = $pdo->prepare("UPDATE penjualan SET jumlah = ?, total = ? WHERE id = ?");
            $stmt_update_penjualan->execute([$jumlah, $total, $id]);

            // Update stok produk
            $stmt_update_stok_produk = $pdo->prepare("UPDATE produk SET stok = stok + ? WHERE id = ?");
            $stmt_update_stok_produk->execute([$penjualan['jumlah_penjualan'] - $jumlah, $penjualan['produk_id']]);

            echo "Penjualan berhasil diupdate!";
            header("Location: daftar_penjualan.php");
            exit();
        } else {
            echo "Gagal mengupdate penjualan. Stok tidak mencukupi.";
        }
    } else {
        echo "Penjualan tidak ditemukan!";
    }
} else {
    $id = $_GET['id'];

    // Ambil data penjualan
    $stmt = $pdo->prepare("SELECT p.nama, pj.jumlah FROM penjualan pj JOIN produk p ON pj.produk_id = p.id WHERE pj.id = ?");
    $stmt->execute([$id]);
    $penjualan = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Edit Penjualan</h1>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="produk">Produk:</label>
                <input type="text" class="form-control" id="produk" name="produk" value="<?php echo $penjualan['nama']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo $penjualan['jumlah']; ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </form>
    </div>
</body>
</html>
