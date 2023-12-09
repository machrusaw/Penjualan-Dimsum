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
        				<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['nama_pelanggan'] ?>" class="from-control" >
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
        				<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['telepon_pelanggan'] ?>" class="from-control" >
        			</div>
        		</div>
        		<div class="col-md-4">
        				<select class="from-control" name="id_ongkir">
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
        		<textarea class="from-control" name="alamat_pengiriman" cols="100" rows="2" placeholder="masukan alamat lengkap pengiriman(termasuk kode pos)"></textarea>
        	</div>
        	<button class="btn btn-primary" name="checkout" style="background: #F63724">Checkout</button>
        </form>

        <?php 
        if (isset($_POST["checkout"]))
        {
           $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
           $id_ongkir = $_POST["id_ongkir"];
           $tanggal_pembelian = date("Y-m-d");
           $alamat_pengiriman = $_POST['alamat_pengiriman'];

           if ($id_ongkir==''|| $alamat_pengiriman==''){
              echo "<script>alert('Data Belum Lengkap!!! ');</script>";
            }else {

                 $ambil = $koneksi->query("SELECT *FROM ongkir WHERE id_ongkir='$id_ongkir'");
                 $arrayongkir = $ambil->fetch_assoc();
                 $nama_kota = $arrayongkir['nama_kota'];
                 $tarif = $arrayongkir['tarif'];

                 $total_pembelian = $totalbelanja + $tarif;

                 $koneksi->query("INSERT INTO pembelian (id_pelanggan,id_ongkir,tanggal_pembelian,total_pembelian,nama_kota,tarif,alamat_pengiriman)
                 	                VALUES ('$id_pelanggan','$id_ongkir','$tanggal_pembelian','$total_pembelian','$nama_kota','$tarif','$alamat_pengiriman') ");

                 $id_pembelian_barusan = $koneksi->insert_id;

                 foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) 
                 {
                 	    $ambil=$koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                      $perproduk = $ambil->fetch_assoc();

                      $nama = $perproduk['nama_produk'];
                      $harga = $perproduk['harga_produk'];
                      $berat = $perproduk['berat_produk'];

                      $subberat = $perproduk['berat_produk']*$jumlah;
                      $subharga = $perproduk['harga_produk']*$jumlah;
                 	    $koneksi->query("INSERT INTO pembelian_produk (id_pembelian,id_produk,nama,harga,berat,subberat,subharga,jumlah)
                 	                VALUES ('$id_pembelian_barusan','$id_produk','$nama','$harga','$berat','$subberat','$subharga','$jumlah') ");

                 }

				 // Mengembalikan stok produk yang dihapus dari keranjang
          
				//  $stok = $produk['stock'];
				//  $koneksi->query("UPDATE produk SET stock = stock + $jumlah  WHERE id_produk = '$id_produk'");

                 unset($_SESSION["keranjang"]);

                 echo "<script>alert('Pembelian Berhasil');</script>";
                 echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";

              }
            }
        ?>

	</div>
</section>
</div>
<?php include 'footer.php'?>

</body>
</html>