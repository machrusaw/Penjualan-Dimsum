<?php
session_start();
include 'koneksi.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
<style>
	body{
	background: #FFF3F3;
    background-repeat:repeat;
    background-size: 45px;
	}
.row{
	padding-top: 200px;
	padding-right: 165px;
}
.gambar{
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

<div class="badan">
<div class="container">
	<div class="row">
			<div class="col-md-4 col-md-offset-5">
			<div class="panel panel-default">
				<div class="gambar">
				<div class="panel-heading">
					<h3 class="panel-title"><b>Login</b></h3>
				</div>
				<div class="panel-body">
					<form method="post">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email" placeholder="email@gmail.com">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password" placeholder="Password">
						</div> 
						<button class="btn btn-primary" name="login" style="background: #F63724">Login</button>
					</form>
					<br>
					Belum Mendaftar ?<a href="daftar.php" style="color: grey"> Klik disini</a>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
	</div>
</div>
</div>
<?php


if (isset($_POST["login"])) 
{
	$email = $_POST["email"];
	$password = $_POST["password"];
	$password_encrypted = md5($password);

	$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' AND password_pelanggan='$password_encrypted'");

	$akunyangcocok = $ambil->num_rows;
	if ($akunyangcocok == 1) {
		$akun = $ambil->fetch_assoc();
		$_SESSION["pelanggan"] = $akun;

		echo "<script>alert('Anda berhasil login');</script>";

		if (isset($_SESSION["keranjang"]) or !empty($_SESSION["keranjang"])) {
			echo "<script>location='checkout.php';</script>";
		}
		else {
			echo "<script>location='index.php';</script>";
		}
	}
	else {
		echo "<script>alert('Anda gagal login, Silahkan periksa akun Anda');</script>";
		echo "<script>location='login.php';</script>";
	}
}

?>

</body>
</html>
