<?php 
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Detail Pembayaran</title>
	<link rel="shortcut icon" href="3.png">
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<style>
	.nav>li>a:hover,
.nav>li>a:focus {
  text-decoration: none;
  background-color: #900000;
}
</style>
<body>

<?php include 'menu.php';?>

<section class="konten">
	<div class="container">

		<h2>Detail Pembelian</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan WHERE pembelian.id_pembelian='$_GET[id]'");
$detail = $ambil->fetch_assoc();
?>

<?php

$idpelangganyangbeli = $detail["id_pelanggan"];
$idpelangganyanglogin = $_SESSION["pelanggan"]["id_pelanggan"];

if ($idpelangganyangbeli!==$idpelangganyanglogin)
{
	echo "<script>alert('jangan mengganti id pelanggan');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}

?>

<div class="row">
	<div class="col-md-4">
		<h3>Pembelian</h3>
	<strong>No. Pembelian: <?php echo $detail['id_pembelian'] ?></strong><br>
	Tanggal: <?php echo $detail['tanggal_pembelian']; ?><br>
	Total: <?php echo number_format($detail['total_pembelian']); ?>
	</div>
	<div class="col-md-4">
		<h3>Pelanggan</h3>
	<strong><?php echo $detail['nama_pelanggan']; ?></strong><br>
	<p>
	    <?php echo $detail['telepon_pelanggan']; ?><br>
	    <?php echo $detail['email_pelanggan']; ?>
    </p>
	</div>
	<div class="col-md-4">
		<h3>Pengiriman</h3>
	<strong><?php echo $detail['nama_kota'] ?></strong><br>
	Ongkos Kirim: Rp. <?php echo number_format($detail['tarif']); ?><br>
	Alamat: <?php echo $detail['alamat_pengiriman'] ?>
	</div>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Produk</th>
			<th>Harga</th>
			<th>Berat</th>
			<th>Jumlah</th>
			<th>Subberat</th>
			<th>Subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1; ?>
		<?php $ambil=$koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'"); ?>
		<?php while ($pecah = $ambil->fetch_assoc()){?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama']; ?></td>
			<td>Rp. <?php echo number_format($pecah['harga']); ?></td>
			<td><?php echo $pecah['berat']; ?> Gram</td>
			<td><?php echo $pecah['jumlah']; ?></td>
			<td><?php echo $pecah['subberat']; ?> Gram</td>
			<td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
		</tr>
	<?php $nomor++; ?>
	<?php } ?>
	</tbody>
</table>

<div class="row">
	<div class="col-md-7">
		<div class="alert alert-info">
			<p>
				Silahkan melakukan pembayaran Rp. <?php echo number_format($detail['total_pembelian']); ?> ke
				<strong>No.Telp/Wa 0822 5726 5681</strong>
			</p>
		</div>
	</div>
</div>
		<a href="riwayat.php" class="btn btn-info" style="background: #F63724">Info Pembayaran</a>
	</div>
</section>

<?php include 'footer.php';?>

</body>
</html>