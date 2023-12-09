<?php
// update_status.php

include 'koneksi.php';

$id_pembelian = $_GET["id"];

// Perbarui status pembelian menjadi "Pesanan Diterima"
$koneksi->query("UPDATE pembelian SET status_pembelian='Pesanan Diterima' WHERE id_pembelian='$id_pembelian'");

echo "<script>alert('Status pembayaran telah diperbarui menjadi Pesanan Diterima.');</script>";
echo "<script>location='riwayat.php';</script>";
?>
