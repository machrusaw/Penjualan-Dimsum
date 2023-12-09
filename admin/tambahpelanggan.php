<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h2>Tambah Pelanggan</h2>

<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Email</label>
		<input type="email" class="form-control" name="email">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="password" class="form-control" name="password">
	</div>
	<div class="form-group">
		<label>Nama</label>
		<input type="text" class="form-control" name="nama">
	</div>
	<div class="form-group">
		<label>Telepon</label>
		<input type="number" class="form-control" name="telepon">
	</div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>

<?php
// Membuat koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toko_online";

$koneksi = new mysqli($servername, $username, $password, $dbname);

// Menjalankan stored procedure untuk menambahkan pelanggan
if (isset($_POST['save'])) {
    // Mendapatkan nilai dari form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];

    // Mengeksekusi stored procedure
    $sql = "CALL tambah_pelanggan('$email', '$password', '$nama', '$telepon')";
    $result = $koneksi->query($sql);

    if ($result) {
        echo "<div class='alert alert-info'>Dimsum Telah Tersimpan</div>";
        echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=pelanggan'>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan dimsum</div>";
    }
}
?>


</body>
</html>