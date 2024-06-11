<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $stmt = $pdo->prepare("INSERT INTO produk (nama, harga, stok) VALUES (?, ?, ?)");
    if ($stmt->execute([$nama, $harga, $stok])) {
        echo "Produk berhasil ditambahkan!";
        header("Location: daftar_produk.php");
    } else {
        echo "Gagal menambahkan produk!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Tambah Produk</h1>
        <a href="daftar_produk.php" class="btn btn-secondary mb-3">Kembali</a>
        <form method="post">
            <div class="form-group">
                <label for="nama">Nama Produk:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" class="form-control" id="stok" name="stok" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Tambah Produk</button>
        </form>
    </div>
</body>
</html>
