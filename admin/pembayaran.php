<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<h2>Data Pembayaran</h2>

<?php 

$id_pembelian = $_GET['id'];
$ambil = $koneksi->query("SELECT * FROM view_pembayaran WHERE id_pembelian='$id_pembelian'");
$detail = $ambil->fetch_assoc();

?>

<div class="row">
	<div class="col-md-6">
		<table class="table">
			<tr>
				<th>Jumlah</th>
				<td>Rp. <?php echo number_format($detail['jumlah']) ?></td>
			</tr>
			<tr>
				<th>Tanggal</th>
				<td><?php echo $detail['tanggal'] ?></td>
			</tr>
		</table>

	</div>
		<img src="../bukti_pembayaran/<?php echo $detail['bukti'] ?>" width="150" height="150">
</div>

<form method="post">
	<div class="form-group">
		<label>Status</label>
		<select class="form-control" name="status">
			<option value="">--Pilih Status--</option>
            <option value="lunas">Lunas</option>
            <option value="barang dikirim">Barang Dikirim</option>
            <option value="batal">Batal</option>
		</select>
	</div>
	<button class="btn btn-primary" name="proses" style="background: #5cb85c">Proses</button>
</form>

<?php

if (isset($_POST["proses"])) {
    $status = $_POST["status"];
    $koneksi->query("UPDATE pembelian SET status_pembelian='$status' WHERE id_pembelian='$id_pembelian'");

    echo "<script>alert('Data Pembelian Terupdate');</script>";
    echo "<script>location='index.php?halaman=pembelian';</script>";
}


?>

</body>
</html>
