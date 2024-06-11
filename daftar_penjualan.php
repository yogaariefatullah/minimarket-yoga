<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$stmt = $pdo->prepare("SELECT pj.id, p.nama, pj.jumlah, pj.total, pj.tanggal FROM penjualan pj JOIN produk p ON pj.produk_id = p.id");
$stmt->execute();
$penjualan = $stmt->fetchAll();

$currentDate = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <p>Today's Date: <?php echo $currentDate; ?></p>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Daftar Penjualan</h1>
        <a href="index.php" class="btn btn-secondary mb-3">Tambah Penjualan</a>
        <a href="daftar_produk.php" class="btn btn-secondary mb-3">Data Produk</a>
        <a href="logout.php" class="btn btn-secondary mb-3">Logout</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($penjualan as $p) { ?>
                    <tr>
                        <td><?php echo $p['nama']; ?></td>
                        <td><?php echo $p['jumlah']; ?></td>
                        <td><?php echo $p['total']; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($p['tanggal'])); ?></td>
                        <td>
                            <a href="edit_penjualan.php?id=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_penjualan.php?id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>