<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Daftar</title>
	<link rel="shortcut icon" href="../3.png">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
<style>

body{
    background: url('../3.png');
    background-repeat:repeat;
    background-size: 60px;
    } 
.row{
    padding-top: 190px;
}
.badan{
    font-color:black;
    box-shadow: 0px 0px 300px black;
    background: white;
    background-size: cover;
    background-attachment: fixed;
}
/* body{
    background: url('images/0.jpg');
    background-size: cover;
    background-attachment: fixed;
	}
.row{
	padding-top: 160px;
}
.badan{
	box-shadow: 0px 0px 300px black;
	color: white;
	background: url('images/0.jpg');
    background-size: cover;
    background-attachment: fixed;
} */
</style>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="badan">
				<div class="panel-heading">
					<h1 class="panel-title"><b><center>Daftar Admin</center></b></h1>
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
							<label class="control-label col-md-3">Username</label>
							<div class="col-md-7">
							<input type="text" class="form-control" name="username" required>
						    </div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Password</label>
							<div class="col-md-7">
							<input type="password" class="form-control" name="password" required>
							</div>	
						</div>	
						<div class="form-group">
							<div class="col-md-7 col-md-offset-3">
								<button class="btn btn-primary" name="daftar">Daftar</button>
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
include 'koneksi.php';
if (isset($_POST["daftar"])) {
	$nama = $_POST["nama"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$password_encrypted = md5($password);

	$ambil = $koneksi->query("SELECT * FROM admin WHERE username='$username'");

	$akunyangcocok = $ambil->num_rows;
	if ($akunyangcocok > 0) {
		echo "<script>alert('pendaftaran gagal, email sudah digunakan');</script>";
		echo "<script>location='daftar.php';</script>";
	}
	else {
		$koneksi->query("INSERT INTO admin(nama,username,password) VALUES('$nama','$username','$password_encrypted') ");
		echo "<script>alert('pendaftaran berhasil');</script>";
		echo "<script>location='login.php';</script>";
	}
}
?>

</body>
</html>