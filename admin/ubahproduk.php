<!DOCTYPE html>
<html>
<head>
	<title></title>
	
</head>
<body>
	<h2>Edit Produk</h2>
<?php 

$ambil=$koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
$pecah = $ambil->fetch_assoc();

?>
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Nama Produk</label>
		<input type="text" class="form-control" name="nama" value="<?php echo $pecah ['nama_produk'];?>">
	</div>
	<div class="form-group">
		<label>Harga (Rp)</label>
		<input type="number" class="form-control" name="harga" value="<?php echo $pecah ['harga_produk'];?>">
	</div>
	<div class="form-group">
		<label>Berat (Gr)</label>
		<input type="number" class="form-control" name="berat" value="<?php echo $pecah ['berat_produk'];?>">
	</div>
	<div class="form-group">
        <label>Stock</label>
        <input type="number" class="form-control" name="stock" value="<?php echo $pecah['stock']; ?>">
</div>

	<div class="form-group">
        <label>Ganti Foto</label>
        <input type="file" name="foto" class="form-control">
    </div>
	<div class="form-group">
		<label>Deskripsi</label>
		<textarea name="deskripsi" class="form-control" rows="10"><?php echo $pecah ['deskripsi_produk']; ?>
		</textarea>
	</div>
    <a href="ubahproduk.php"><button class="btn btn-primary" name="ubah">Edit</button></a>
</form>

<?php
if (isset($_POST['ubah'])) {
    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];

    if (empty($lokasifoto)) {
        $koneksi->query("CALL ubah_produk(
            $_GET[id],
            '$_POST[nama]',
            $_POST[harga],
            $_POST[berat],
            (SELECT foto_produk FROM produk WHERE id_produk = $_GET[id]),
            '$_POST[deskripsi]',
            $_POST[stock]
        )");
    } else {
        move_uploaded_file($lokasifoto, "../foto_produk/$namafoto");
        $koneksi->query("CALL ubah_produk(
            $_GET[id],
            '$_POST[nama]',
            $_POST[harga],
            $_POST[berat],
            '$namafoto',
            '$_POST[deskripsi]',
            $_POST[stock]
        )");
    }
    echo "<script>alert('Data Dimsum Telah diubah');</script>";
    echo "<script>location='index.php?halaman=produk';</script>";
}

?>


</body>
</html>
