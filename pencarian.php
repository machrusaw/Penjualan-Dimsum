<?php
include 'koneksi.php';

$keyword = $_GET["keyword"];

$semuadata=array();
$ambil = $koneksi->query("SELECT * FROM produk 
	WHERE nama_produk LIKE '%$keyword%' 
	OR deskripsi_produk LIKE '%$keyword%'");
	while($pecah = $ambil->fetch_assoc())
	{
		$semuadata[]=$pecah;
	}
    // echo "<pre>";
    // print_r($semuadata);
    // echo "</pre>";
    

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
<style>
    body{
    color: black;
    background: white;
    background-size: cover;
    background-attachment: fixed;
    }
.panel{
    text-align: center;
    overflow: hidden;
    padding: 0px;
    max-height: 260px;
    min-height: 260px;
    max-width: 250px;
    min-width: 250px;
}
</style>
</head>
<body>

<?php include 'menu.php'; ?>
    <div class="container">
    	<h3>Hasil Pencarian : <?php echo $keyword ?></h3>

    	<?php if (empty($semuadata)): ?>
            <div class="alert alert-danger">Dimsum <strong><?php echo $keyword ?></strong> tidak ditemukan</div>
    	<?php endif ?>

    	<div class="row">
            <?php foreach ($semuadata as $key => $value): 

            ?>
    		<div class="col-md-3">
    			<div class="thumbnail">
                    <div class="panel">
    				<a href="detail.php?id=<?php echo $value["id_produk"]; ?>">
                        <img src="foto_produk/<?php echo $value["foto_produk"] ?>" class="img-responsive" width="250" height="260" alt="">
                    </a>
                    </div>
					<div class="caption">
						<h3><?php echo $value["nama_produk"] ?></h3>
						<h5>Rp. <?php echo number_format($value["harga_produk"]) ?></h5>
						<a href="beli.php?id=<?php echo $value['id_produk']; ?>" class="btn btn-primary">Beli</a>
						<a href="detail.php?id=<?php echo $value["id_produk"]; ?>" class="btn btn-default">Detail</a>
					</div>
    			</div>
    		</div>
            <?php endforeach ?>

    	</div>
    </div>
<?php include 'footer.php';?>
</body>
</html>