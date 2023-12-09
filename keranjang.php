<?php
session_start();

// echo "<pre>";
// print_r($_SESSION['keranjang']);
// echo "</pre>";

include 'koneksi.php';

if (empty($_SESSION["keranjang"]) OR !isset($_SESSION["keranjang"])) 
{
	echo "<script>alert('keranjang kosong, silahkan masukkan pesanan terlebih dahulu');</script>";
    echo "<script>location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Keranjang</title>
	<link rel="shortcut icon" href="3.png">
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
<style>
    body{
	color: black;
    background: #FFF3F3;
    background-size: cover;
    background-attachment: fixed;
	}
	.badan{
    padding-bottom: 140px;
}
.nav>li>a:hover,
.nav>li>a:focus {
  text-decoration: none;
  background-color: #900000;
}
</style>
</head>
<body>

<?php include 'menu.php';?>

<div class="badan">
<section class="konten">
	<div class="container">
		<h1>Keranjang Belanja</h1>
		<hr>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Produk</th>
			<th>Harga</th>
			<th>Jumlah</th>
			<th>Subharga</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1; ?>
		<?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
        <?php 
        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
        $pecah = $ambil->fetch_assoc();
        $subharga = $pecah["harga_produk"]*$jumlah;
        // echo "<pre>";
        // print_r($pecah);
        // echo "</pre>";
        ?>

		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama_produk']; ?></td>
			<td>RP. <?php echo number_format($pecah["harga_produk"]); ?></td>
			<td><?php echo $jumlah; ?></td>
			<td>Rp. <?php echo number_format($subharga); ?></td>
			<td>
				<a href="hapuskeranjang.php?id=<?php echo $id_produk ?>" class="btn btn-danger btn-xs">Hapus</a>
			</td>
		</tr>
		<?php $nomor++; ?>
	<?php endforeach  ?>
	</tbody>
</table>

<a href="index.php" class="btn btn-default">Lanjutkan Pesanan</a>
<a href="checkout.php" class="btn btn-primary" style="background: #F63724" >Checkout</a>

	</div>
</section>
</div>

<?php include 'footer.php';?>

</body>
</html>