<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION["pelanggan"])) 
{
    echo "<script>alert('Silahkan login');</script>";
    echo "<script>location='login.php';</script>";
}
if (empty($_SESSION["keranjang"]) OR !isset($_SESSION["keranjang"])) 
{
  echo "<script>alert('Silahkan pesan terlebih dahulu');</script>";
    echo "<script>location='index.php';</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
	<link rel="shortcut icon" href="3.png">
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

<div class="badan">
<section class="konten">
	<div class="container">
		<h1>Checkout</h1>
		<hr>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Produk</th>
			<th>Harga</th>
			<th>Jumlah</th>
			<th>Subharga</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1; ?>
		<?php $totalbelanja = 0; ?>
		<?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
        <?php 
        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
        $pecah = $ambil->fetch_assoc();
        $subharga = $pecah["harga_produk"]*$jumlah;
        // echo "<pre>";
        // print_r($pecah);
        // echo "</pre>";
        ?>

		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama_produk']; ?></td>
			<td>RP. <?php echo number_format($pecah["harga_produk"]); ?></td>
			<td><?php echo $jumlah; ?></td>
			<td>Rp. <?php echo number_format($subharga); ?></td>
		</tr>
		<?php $nomor++; ?>
		<?php $totalbelanja+=$subharga ?>
	<?php endforeach  ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="4">Total Belanja</th>
			<th>Rp. <?php echo number_format($totalbelanja) ?></th>
		</tr>
	</tfoot>
</table>

        <form method="post">
        	<div class="row">
        		<div class="col-md-4">
        			<div class="form-group">
        				<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['nama_pelanggan'] ?>" class="form-control" >
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
        				<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['telepon_pelanggan'] ?>" class="form-control" >
        			</div>
        		</div>
        		<div class="col-md-4">
        				<select class="form-control" name="id_ongkir">
        					<option value="">Pilih Ongkos kirim</option>
        					<?php 
        					$ambil = $koneksi->query("SELECT * FROM ongkir");
                            while ($perongkir = $ambil->fetch_assoc()) {   
        				    ?>
        					<option value="<?php echo $perongkir["id_ongkir"] ?>">
        						<?php echo $perongkir['nama_kota'] ?> -
        						Rp. <?php echo number_format($perongkir['tarif']) ?>
        					</option>
                            <?php } ?>
        				</select>
        		</div>
        	</div>
        	<div class="form-group">
        		<label>Alamat Lengkap Pengiriman</label><br>
        		<textarea class="form-control" name="alamat_pengiriman" cols="100" rows="2" placeholder="masukan alamat lengkap pengiriman(termasuk kode pos)"></textarea>
        	</div>
        	<button class="btn btn-primary" name="checkout" style="background: #F63724">Checkout</button>
        </form>

		<?php 
		if (isset($_POST["checkout"])) {
			$id_pelanggan       = $_SESSION["pelanggan"]["id_pelanggan"];
			$id_ongkir          = $_POST["id_ongkir"] ?? '';
			$tanggal_pembelian  = date("Y-m-d");
			$alamat_pengiriman  = trim($_POST['alamat_pengiriman'] ?? '');

			if ($id_ongkir === '' || $alamat_pengiriman === '') {
				echo "<script>alert('Data Belum Lengkap!!!');</script>";
				echo "<script>location='checkout.php';</script>";
				exit;
			}

			// Ambil ongkir
			$ambil       = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir = ".(int)$id_ongkir);
			$arrayongkir = $ambil->fetch_assoc();
			if (!$arrayongkir) {
				echo "<script>alert('Ongkir tidak valid');</script>";
				echo "<script>location='checkout.php';</script>";
				exit;
			}

			$nama_kota = $arrayongkir['nama_kota'];
			$tarif     = (int)$arrayongkir['tarif'];

			// Total akhir
			$total_pembelian = (int)$totalbelanja + $tarif;

			// INSERT ke tabel pembelian (isi kolom resi_pengiriman dengan string kosong)
			$stmt = $koneksi->prepare("
				INSERT INTO pembelian
					(id_pelanggan, id_ongkir, tanggal_pembelian, total_pembelian,
					nama_kota, tarif, alamat_pengiriman, status_pembelian, resi_pengiriman)
				VALUES
					(?, ?, ?, ?, ?, ?, ?, 'pending', '')
			");
			// tipe: id_pelanggan (i), id_ongkir (i), tanggal (s), total (i), nama_kota (s), tarif (i), alamat (s)
			$stmt->bind_param(
				'iisisis',
				$id_pelanggan,
				$id_ongkir,
				$tanggal_pembelian,
				$total_pembelian,
				$nama_kota,
				$tarif,
				$alamat_pengiriman
			);
			$stmt->execute();

			$id_pembelian_barusan = $koneksi->insert_id;

			// Simpan detail item yang dibeli
			foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) {
				$id_produk = (int)$id_produk;
				$jumlah    = (int)$jumlah;

				$ambil     = $koneksi->query("SELECT * FROM produk WHERE id_produk = $id_produk");
				$perproduk = $ambil->fetch_assoc();
				if (!$perproduk) continue;

				$nama     = $perproduk['nama_produk'];
				$harga    = (int)$perproduk['harga_produk'];
				$berat    = (int)$perproduk['berat_produk'];
				$subberat = $berat * $jumlah;
				$subharga = $harga * $jumlah;

				$stmt2 = $koneksi->prepare("
					INSERT INTO pembelian_produk
					(id_pembelian, id_produk, nama, harga, berat, subberat, subharga, jumlah)
					VALUES (?, ?, ?, ?, ?, ?, ?, ?)
				");
				$stmt2->bind_param('iisiiiii', $id_pembelian_barusan, $id_produk, $nama, $harga, $berat, $subberat, $subharga, $jumlah);
				$stmt2->execute();
			}

			// kosongkan keranjang
			unset($_SESSION["keranjang"]);

			echo "<script>alert('Pembelian Berhasil');</script>";
			echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";
			exit;
		}
		?>

	</div>
</section>
</div>
<?php include 'footer.php'?>

</body>
</html>