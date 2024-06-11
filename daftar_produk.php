<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$stmt = $pdo->prepare("SELECT * FROM produk");
$stmt->execute();
$produk = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Daftar Produk</h1>
        <a href="daftar_penjualan.php" class="btn btn-secondary mb-3">Kembali</a>
        <a href="tambah_produk.php" class="btn btn-primary mb-3">Tambah Produk</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk as $p) { ?>
                    <tr>
                        <td><?php echo $p['id']; ?></td>
                        <td><?php echo $p['nama']; ?></td>
                        <td><?php echo $p['harga']; ?></td>
                        <td><?php echo $p['stok']; ?></td>
                        <td>
                            <a href="edit_produk.php?id=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_produk.php?id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
