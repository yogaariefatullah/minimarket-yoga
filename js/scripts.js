$(document).ready(function() {
    // Muat daftar produk
    $.ajax({
        url: 'produk.php',
        type: 'GET',
        success: function(data) {
            $('#produk').html(data);
        }
    });

    // Form submit
    $('#form-penjualan').submit(function(e) {
        e.preventDefault();
        var produk = $('#produk').val();
        var jumlah = $('#jumlah').val();

        $.ajax({
            url: 'proses_penjualan.php',
            type: 'POST',
            data: { produk: produk, jumlah: jumlah },
            success: function(response) {
                alert(response);
                $('#form-penjualan')[0].reset();
            }
        });
    });
});
