<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM produk WHERE id = ?");
if ($stmt->execute([$id])) {
    echo "Produk berhasil dihapus!";
    header("Location: daftar_produk.php");
} else {
    echo "Gagal menghapus produk!";
}
?>
