<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produk_id = $_POST['produk'];
    $jumlah = $_POST['jumlah'];

    // Ambil data produk
    $stmt = $pdo->prepare("SELECT harga, stok FROM produk WHERE id = ?");
    $stmt->execute([$produk_id]);
    $produk = $stmt->fetch();

    if ($produk) {
        if ($produk['stok'] >= $jumlah) {
            $total = $produk['harga'] * $jumlah;
            $tanggal = date('Y-m-d');

            // Simpan ke tabel penjualan
            $stmt = $pdo->prepare("INSERT INTO penjualan (produk_id, jumlah, total, tanggal) VALUES (?, ?, ?, ?)");
            $stmt->execute([$produk_id, $jumlah, $total, $tanggal]);

            // Kurangi stok produk
            $stmt = $pdo->prepare("UPDATE produk SET stok = stok - ? WHERE id = ?");
            $stmt->execute([$jumlah, $produk_id]);

            echo "Penjualan berhasil disimpan!";
            header("Location: daftar_pern.php");
        } else {
            echo "Stok tidak mencukupi!";
        }
    } else {
        echo "Produk tidak ditemukan!";
    }
}
