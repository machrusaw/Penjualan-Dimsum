<?php 
session_start();
include 'koneksi.php';

if (!isset($_SESSION["pelanggan"]) OR empty($_SESSION["pelanggan"])) 
{
	echo "<script>alert('silahkan login terlebih dahulu');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}
?>

 <!DOCTYPE html>
<html>
<head>
	<title>Riwayat Pemesanan</title>
	<link rel="shortcut icon" href="3.png">
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
<style>
.badan{
	padding-bottom: 225px; 
	background: #FFF3F3;
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

<!-- <pre>
	<?php print_r($_SESSION) ?>
</pre> -->
<div class="badan">
<section class="riwayat">
	<div class="container">
		<h3>Riwayat Belanja <?php echo $_SESSION["pelanggan"]["nama_pelanggan"] ?></h3>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal</th>
					<th>Status</th>
					<th>Total</th>
					<th>Opsi</th>
				</tr>
			</thead>
			<tbody>
				<?php $nomor=1; ?>
				<?php
                    $id_pelanggan = $_SESSION["pelanggan"]['id_pelanggan'];

                    $ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pelanggan='$id_pelanggan'");
                    while($pecah = $ambil->fetch_assoc()){
                    	?>
				<tr>
					<td><?php echo $nomor; ?></td>
					<td><?php echo $pecah["tanggal_pembelian"] ?></td>
					<td>
						<?php echo $pecah["status_pembelian"] ?>
						<br>
					<td>Rp. <?php echo number_format($pecah["total_pembelian"]) ?></td>
					<td>
						<a href="nota.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-info" style="background: #F63724">Nota</a>

						<?php if ($pecah['status_pembelian']=="pending"): ?>
						<a href="pembayaran.php?id=<?php echo $pecah["id_pembelian"]; ?>" class="btn btn-success">Silahkan Dibayar
						</a>
						<?php else: ?>
							<a href="lihat_pembayaran.php?id=<?php echo $pecah["id_pembelian"]; ?>" class="btn btn-warning">
								Lihat Pembayaran
							</a>
							<a href="cetak_slip_pembayaran.php?id=<?php echo $pecah["id_pembelian"]; ?>" class="btn btn-default">Cetak
							</a>
							<a href="update_status.php?id=<?php echo $pecah["id_pembelian"]; ?>" class="btn btn-default">Pesanan Diterima
							</a>
					<?php endif ?>
					</td>
				</tr>
			<?php $nomor++; ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</section>
</div>

<?php include 'footer.php';?>

</body>
</html>