<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
<style>
	body{
    background-repeat:repeat;
    background-size: 45px;
	}
.row{
	padding-top: 60px;
}
.badan{
	
	font-color:black;
    background: #F4EFE5;
    background-size: cover;
    background-attachment: fixed;
}

.nav>li>a:hover,
.nav>li>a:focus {
  text-decoration: none;
  background-color: #900000;
}
</style>
</head>
<body>

<?php include 'menu.php'; ?>


<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="badan">
				<div class="panel-heading">
					<h1 class="panel-title"><b>Daftar Pelanggan</b></h1>
				</div>
				<div class="panel-body">
					<form method="post" class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-md-3">Nama</label>
							<div class="col-md-7">
							<input type="text" class="form-control" name="nama" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Email</label>
							<div class="col-md-7">
							<input type="email" class="form-control" name="email" required>
						    </div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Password</label>
							<div class="col-md-7">
							<input type="password" class="form-control" name="password" required>
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Alamat</label>
							<div class="col-md-7">
							<textarea class="form-control" name="alamat" required></textarea>
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">No. Telp</b></label>
							<div class="col-md-7">
							<input type="number" class="form-control" name="telepon" required>
							</div>	
						</div>
						<div class="form-group">
							<div class="col-md-7 col-md-offset-3">
								<button class="btn btn-primary" name="daftar" style="background: #F63724">Daftar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

    <?php
if (isset($_POST["daftar"])) {
	$nama = $_POST["nama"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$password_encrypted = md5($password);
	$alamat = $_POST["alamat"];
	$telepon = $_POST["telepon"];

	$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email'");

	$yangcocok = $ambil->num_rows;
	if ($yangcocok == 1) {
		echo "<script>alert('pendaftaran gagal, email sudah digunakan');</script>";
		echo "<script>location='daftar.php';</script>";
	}
	else {
		$koneksi->query("INSERT INTO pelanggan(email_pelanggan,password_pelanggan,nama_pelanggan,telepon_pelanggan,alamat_pelanggan) VALUES('$email','$password_encrypted','$nama','$telepon','$alamat') ");

		echo "<script>alert('pendaftaran sukses, Silahkan login');</script>";
		echo "<script>location='login.php';</script>";
	}
}
?>

</body>
</html>