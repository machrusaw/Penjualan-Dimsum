<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Menghapus semua produk dari keranjang
    if (isset($_SESSION['keranjang'])) {
        $keranjang = $_SESSION['keranjang'];

        // Cek apakah produk ada dalam keranjang
        if (array_key_exists($id_produk, $keranjang)) {
            $jumlah = $keranjang[$id_produk];

            // Mengembalikan stok produk yang dihapus dari keranjang
            $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk = '$id_produk'");
            $produk = $ambil->fetch_assoc();

            $stok = $produk['stock'];
            $koneksi->query("UPDATE produk SET stock = stock + $jumlah WHERE id_produk = '$id_produk'");

            // Hapus produk dari keranjang
            unset($keranjang[$id_produk]);

            // Simpan kembali keranjang ke session
            $_SESSION['keranjang'] = $keranjang;

            echo "<script>alert('Produk dihapus dari keranjang.')</script>";
            echo "<script>window.location.href='keranjang.php'</script>";
        }
    }
}
?>
