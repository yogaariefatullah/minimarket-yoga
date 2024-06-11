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
    $stmt = $pdo->prepare("SELECT produk_id, (SELECT harga FROM produk WHERE id = penjualan.produk_id) as harga FROM penjualan WHERE id = ?");
    $stmt->execute([$id]);
    $penjualan = $stmt->fetch();

    if ($penjualan) {
        $total = $penjualan['harga'] * $jumlah;

        // Update penjualan
        $stmt = $pdo->prepare("UPDATE penjualan SET jumlah = ?, total = ? WHERE id = ?");
        $stmt->execute([$jumlah, $total, $id]);

        // Update stok produk
        $stmt = $pdo->prepare("UPDATE produk SET stok = stok + (SELECT jumlah FROM penjualan WHERE id = ?) - ? WHERE id = ?");
        $stmt->execute([$id, $jumlah, $penjualan['produk_id']]);

        echo "Penjualan berhasil diupdate!";
        header("Location: daftar_penjualan.php");
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
        <h1 class="text-center">Edit Penjualan
        </h1>
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
