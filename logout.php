<?php 
session_start();
include 'koneksi.php';

if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk = '$id_produk'");
        $produk = $ambil->fetch_assoc();

        $stok = $produk['stock'];
        $koneksi->query("UPDATE produk SET stock = stock + $jumlah WHERE id_produk = '$id_produk'");
    }
}

session_destroy();

echo "<script>alert('Anda telah logout');</script>";
echo "<script>location='index.php';</script>";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>
