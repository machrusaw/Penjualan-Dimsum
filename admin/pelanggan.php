<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h2>pelanggan</h2>

<a href="index.php?halaman=tambahpelanggan" class="btn btn-primary">Tambah Pelanggan</a><br><br>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Email</th>
			<th>Nama</th>
			<th>Telepon</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1; ?>
		<?php $ambil=$koneksi->query("SELECT * FROM pelanggan"); ?>
		<?php while ($pecah = $ambil->fetch_assoc()){?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['email_pelanggan']; ?></td>
			<td><?php echo $pecah['nama_pelanggan']; ?></td>
		    <td><?php echo $pecah['telepon_pelanggan']; ?></td>
			<td>
				<a href="index.php?halaman=hapuspelanggan&id=<?php echo $pecah['id_pelanggan']; ?>" class="btn-danger btn">Delete</a>
			</td>
		</tr>
	<?php $nomor++; ?>
	<?php } ?>
	</tbody>
</table>
</body>
</html>
