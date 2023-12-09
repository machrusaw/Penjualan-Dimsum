<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
// Menghapus data produk
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
$fotoproduk = $pecah['foto_produk'];

if (file_exists("../foto_produk/$fotoproduk")) {
    unlink("../foto_produk/$fotoproduk");
}

// Menghapus file gambar yang sesuai dengan data produk yang dihapus
$folder = "../foto_produk/";
$files = scandir($folder);

foreach ($files as $file) {
    if (is_file($folder . $file) && $file != '.' && $file != '..') {
        $file_produk = $file;
        if ($file_produk == $fotoproduk) {
            unlink($folder . $file_produk);
        }
    }
}

// Memanggil stored procedure hapus_produk
$stmt = $koneksi->prepare("CALL hapus_produk(?)");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$stmt->close();

echo "<script>alert('Produk Telah Terhapus');</script>";
echo "<script>location='index.php?halaman=produk';</script>";
?>


</body>
</html>
