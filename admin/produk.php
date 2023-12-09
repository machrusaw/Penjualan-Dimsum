<!DOCTYPE html>
<html>
<head>
	<title></title>

    <style>
        .btn-primary {
            background: #FFDE59;
            color: black;
        }
        .btn-danger {
            background: #F63724;
        }
        .btn-warning {
            background: #FF914D;
        }
    </style>
</head>
<body>
<h2>Produk</h2>

<a href="index.php?halaman=tambahproduk" class="btn btn-primary">Tambah Data</a>
<a href="index.php?halaman=tambah1lusin" class="btn btn-primary" style="background:#5cb85c">Update Stock 1 Lusin</a><br><br>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama</th>
			<th>Harga</th>
			<th>Berat</th>
			<th>Foto</th>
			<th>Stok</th> <!-- Kolom baru untuk stok -->
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
        
    <?php $nomor = 1; ?>
    <?php $ambil = $koneksi->query("SELECT * FROM produk"); ?>
    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama_produk']; ?></td>
            <td><?php echo $pecah['harga_produk']; ?></td>
            <td><?php echo $pecah['berat_produk']; ?></td>
            <td>
                <div class="panel-body">
                    <center>
                        <img src="../foto_produk/<?php echo $pecah['foto_produk']; ?>" width="95" height="100">
                    </center>
                </div>
            </td>
            <td><?php echo $pecah['stock']; ?></td> <!-- Menampilkan jumlah stok -->
            <td>
                <a href="index.php?halaman=hapusproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn-danger btn">Hapus</a>
                <a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn btn-warning">Edit</a>
            </td>
        </tr>
        <?php $nomor++; ?>
    <?php } ?>
	</tbody>
</table>

</body>
</html>
