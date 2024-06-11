<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$id = $_GET['id'];

// Ambil data penjualan untuk mengembalikan stok
$stmt = $pdo->prepare("SELECT produk_id, jumlah FROM penjualan WHERE id = ?");
$stmt->execute([$id]);
$penjualan = $stmt->fetch();

if ($penjualan) {
    // Hapus penjualan
    $stmt = $pdo->prepare("DELETE FROM penjualan WHERE id = ?");
    $stmt->execute([$id]);

    // Kembalikan stok produk
    $stmt = $pdo->prepare("UPDATE produk SET stok = stok + ? WHERE id = ?");
    $stmt->execute([$penjualan['jumlah'], $penjualan['produk_id']]);

    echo "Penjualan berhasil dihapus!";
    header("Location: daftar_penjualan.php");
} else {
    echo "Penjualan tidak ditemukan!";
}
?>
