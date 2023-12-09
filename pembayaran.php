<?php 
session_start();
include 'koneksi.php';

if (!isset($_SESSION["pelanggan"]) OR empty($_SESSION["pelanggan"])) 
{
	echo "<script>alert('silahkan login terlebih dahulu');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}

$idpem = $_GET["id"];
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$idpem'");
$detpem = $ambil->fetch_assoc();

$id_pelanggan_beli = $detpem["id_pelanggan"];
$id_pelangan_login = $_SESSION["pelanggan"]["id_pelanggan"];

if ($id_pelangan_login !==$id_pelanggan_beli) 
{
	echo "<script>alert('jangan mengubah id pembelian');</script>";
    echo "<script>location='riwayat.php';</script>";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
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

<div class="container">
    <h2>Konfirmasi Pembayaran</h2>
    <p>Kirim bukti Pembayaran Anda disini</p>
    <div class="alert alert-info">total tagihan Anda <strong>Rp. <?php echo number_format($detpem["total_pembelian"]) ?></strong></div>
		<div class="alert alert-info">
			<p>
				Silahkan melakukan pembayaran ke
				<strong>No.Telp/Wa 0822 5726 5681</strong>
			</p>
		</div>

	<form method="post" enctype="multipart/form-data">
	    <!-- <div class="form-group">
			<label>Nama Penyetor</label>
			<input type="text" class="form-control" name="nama">
		</div> -->
		<div class="form-group">
			<label>Jumlah</label>
			<input type="number" class="form-control" name="jumlah" min="1">
		</div>
		<div class="form-group">
	        <label>Bukti Pembayaran</label>
	        <input type="file" class="form-control" name="bukti">
  	    </div>
		<button class="btn btn-primary" name="kirim" style="background: #F63724">Kirim</button>
	</form>
</div>

<?php 

if (isset($_POST["kirim"])) 
{
	$namabukti = $_FILES["bukti"]["name"];
	$lokasibukti = $_FILES["bukti"]["tmp_name"];
	$namafiks = date("YmdHis").$namabukti;
	move_uploaded_file($lokasibukti, "bukti_pembayaran/$namafiks");

	// $nama = $_POST["nama"];
	$jumlah = $_POST["jumlah"];
	$tanggal = date("Y-m-d");

	if ($jumlah==''|| $namabukti==''){
              echo "<script>alert('Data Belum Lengkap!!! ');</script>";
            }else {

				    $koneksi->query("INSERT INTO pembayaran(id_pembelian,jumlah,tanggal,bukti) VALUES ('$idpem','$jumlah','$tanggal','$namafiks') ");

				    $koneksi->query("UPDATE pembelian SET status_pembelian='sudah kirim pembayaran' WHERE id_pembelian='$idpem'");

				    echo "<script>alert('Terimakasih sudah mengirimkan bukti pembayaran');</script>";
				    echo "<script>location='riwayat.php';</script>";
				}
			}

?>

<?php include 'footer.php';?>

</body>
</html>