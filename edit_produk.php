<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $stmt = $pdo->prepare("UPDATE produk SET nama = ?, harga = ?, stok = ? WHERE id = ?");
    if ($stmt->execute([$nama, $harga, $stok, $id])) {
        echo "Produk berhasil diupdate!";
        header("Location: daftar_produk.php");
    } else {
        echo "Gagal mengupdate produk!";
    }
} else {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->execute([$id]);
    $produk = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Edit Produk</h1>
        <a href="daftar_produk.php" class="btn btn-secondary mb-3">Kembali</a>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $produk['id']; ?>">
            <div class="form-group">
                <label for="nama">Nama Produk:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $produk['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $produk['harga']; ?>" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $produk['stok']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Produk</button>
        </form>
    </div>
</body>
</html>
