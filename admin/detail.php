<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h2>Detail Produk</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM detail_pembelian WHERE id_pembelian='$_GET[id]'");
$detail = $ambil->fetch_assoc();

// Pengecekan apakah data ditemukan
if ($detail) {
?>


<div class="row">
	<div class="col-md-4">
		<table class="table">
			<h3>Pelanggan</h3>
			<tr>
				<th>Nama Pelanggan</th>
				<td><?php echo $detail['nama_pelanggan']; ?></td>
			</tr>
			<tr>
				<th>Telepon</th>
				<td><?php echo $detail['telepon_pelanggan']; ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $detail['email_pelanggan']; ?></td>
			</tr>
		</table>
	</div>
	<div class="col-md-4">
		<table class="table">
			<h3>Pembelian</h3>
			<tr>
				<th>Total Pembelian</th>
				<td>Rp. <?php echo number_format($detail['total_pembelian']); ?></td>
			</tr>
			<tr>
				<th>Tanggal</th>
				<td><?php echo $detail['tanggal_pembelian']; ?></td>
			</tr>
			<tr>
				<th>Status Pembelian</th>
				<td><?php echo $detail['status_pembelian']; ?></td>
			</tr>
		</table>
	</div>
	<div class="col-md-4">
		<table class="table">
			<h3>Pengiriman</h3>
			<tr>
				<th>Nama Kota</th>
				<td><?php echo $detail['nama_kota']; ?></td>
			</tr>
			<tr>
				<th>Tarif</th>
				<td>Rp. <?php echo number_format($detail['tarif']); ?></td>
			</tr>
			<tr>
				<th>Alamat</th>
				<td><?php echo $detail['alamat_pengiriman']; ?></td>
			</tr>
		</table>
	</div>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Produk</th>
			<th>Harga</th>
			<th>Jumlah</th>
			<th>Subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1; ?>
		<?php $ambil_produk=$koneksi->query("SELECT * FROM detail_pembelian WHERE id_pembelian='$_GET[id]'"); ?>
		<?php while ($pecah_produk = $ambil_produk->fetch_assoc()){?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah_produk['nama_produk']; ?></td>
			<td>Rp. <?php echo number_format($pecah_produk['harga']); ?></td>
			<td><?php echo $pecah_produk['jumlah']; ?></td>
			<td>
				Rp. <?php echo number_format($pecah_produk['total_pembelian']); ?>
			</td>
		</tr>
	<?php $nomor++; ?>
	<?php } ?>
	</tbody>
</table>

<?php
} else {
	echo "Dimsum tidak ditemukan.";
}
?>

</body>
</html>
