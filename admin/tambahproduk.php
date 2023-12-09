<?php
$error = "";

if (isset($_POST['save'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $berat = $_POST['berat'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $nama_file = $_FILES['foto']['name'];
    $lokasi_file = $_FILES['foto']['tmp_name'];

    if (empty($nama) || empty($harga) || empty($berat)  || empty($nama_file) || empty($deskripsi)|| empty($stock)) {
        $error = "Harap isi semua kolom input";
    } else {
        move_uploaded_file($lokasi_file, "../foto_produk/" . $nama_file);

        // memanggil procedure
        $stmt = $koneksi->prepare("CALL tambah_barang(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siissi", $nama, $harga, $berat, $nama_file, $deskripsi, $stock);
        $stmt->execute();
        $stmt->close();

        echo "<div class='alert alert-info'>Dimsum Telah Tersimpan</div>";
        echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=produk'>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<h2>Tambah Data</h2>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama">
    </div>
    <div class="form-group">
        <label>Harga (Rp)</label>
        <input type="number" class="form-control" name="harga">
    </div>
    <div class="form-group">
        <label>Berat (Gr)</label>
        <input type="number" class="form-control" name="berat">
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea class="form-control" name="deskripsi" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label>Stock</label>
        <input type="number" class="form-control" name="stock">
    </div>
    <div class="form-group">
        <label>Foto</label>
        <input type="file" class="form-control" name="foto">
    </div>
    <button class="btn btn-primary" name="save" style="background: #F63724; color: black;">Simpan</button>
</form>

<?php
if (!empty($error)) {
    echo "<div class='alert alert-danger'>$error</div>";
}
?>

</body>
</html>
