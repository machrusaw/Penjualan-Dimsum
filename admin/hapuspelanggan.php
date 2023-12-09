<?php

$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
$id_pelanggan = $pecah['id_pelanggan'];

$koneksi->query("CALL delete_pelanggan($_GET[id])");

echo "<script>alert('Pelanggan Telah Terhapus');</script>";
echo "<script>location='index.php?halaman=pelanggan';</script>";

?>
