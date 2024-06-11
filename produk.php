<?php
include 'koneksi.php';

$stmt = $pdo->prepare("SELECT id, nama FROM produk");
$stmt->execute();
$produk = $stmt->fetchAll();

foreach ($produk as $p) {
    echo "<option value='{$p['id']}'>{$p['nama']}</option>";
}
?>
