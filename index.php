<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penjualan Minimarket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Form Penjualan</h1>
        <a href="logout.php" class="btn btn-secondary mb-3">Logout</a> 
        <a href="daftar_penjualan.php" class="btn btn-secondary mb-3">Daftar Penjualan</a>
        <form id="form-penjualan">
            <div class="form-group">
                <label for="produk">Produk:</label>
                <select class="form-control" id="produk" name="produk">
                    <!-- Produk akan dimuat melalui jQuery -->
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
    </div>
</body>
</html>
