<?php
session_start();
include 'koneksi.php';

if(isset($_GET['id'])){
    $id_produk = $_GET['id'];
    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $produk = $ambil->fetch_assoc();

    $stok = $produk['stock'];

    if($stok <= 0){
        echo "<script>alert('Stok produk tidak mencukupi.')</script>";
        echo "<script>window.location.href='index.php'</script>";
        exit;
    }

    // Lanjutkan dengan proses pembelian jika stok mencukupi
    // ...
    // ...
    // (Tambahkan logika atau perintah untuk proses pembelian di sini)
    // ...
    // ...

    // Setelah pembelian berhasil, tambahkan produk ke dalam keranjang
    $keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();

    // Cek apakah produk sudah ada dalam keranjang
    if(array_key_exists($id_produk, $keranjang)){
        // Jika sudah ada, tambahkan jumlah pembelian ke jumlah yang sudah ada
        $keranjang[$id_produk] += 1;
    } else {
        // Jika belum ada, tambahkan produk ke dalam keranjang dengan jumlah 1
        $keranjang[$id_produk] = 1;
    }

    // Simpan kembali keranjang ke session
    $_SESSION['keranjang'] = $keranjang;

    // Kurangi stok produk
    $koneksi->query("UPDATE produk SET stock = stock - 1 WHERE id_produk = '$id_produk'");

	

    echo "<script>alert('Pembelian berhasil.')</script>";
    echo "<script>window.location.href='keranjang.php'</script>";
}
?>
