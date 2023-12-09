<?php
session_start();
?>
<?php
include 'koneksi.php';
?>
<?php
$id_produk = $_GET["id"];

$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
$detail = $ambil->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Detail Produk</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <style>
        .badan {
            padding-bottom: 170px;
            background: #FFF3F3;
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
    <br>
    <div class="badan">
        <section class="konten">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img src="foto_produk/<?php echo $detail["foto_produk"]; ?>" alt="" class="img-responsive">
                    </div>
                    <div class="col-md-6">
                        <h2><?php echo $detail["nama_produk"] ?></h2>
                        <h4>Rp. <?php echo number_format($detail["harga_produk"]); ?></h4>
                        <h4>Stock : <?php echo number_format($detail["stock"]); ?></h4>

                        <form method="post">
    <div class="form-group">
        <div class="input-group">
            <input type="number" min="1" class="form-control" name="jumlah" placeholder="masukkan minimal pemesanan">
            <div class="input-group-btn">
                <button class="btn btn-primary" name="beli" style="background: #F63724">Beli</button>
            </div>
        </div>
    </div>
</form>

<?php
if (isset($_POST["beli"])) {
    $jumlah = $_POST["jumlah"];
    if ($jumlah == '') {
        echo "<script>alert('Silahkan masukkan minimal pemesanan!!!');</script>";
    } else {
        // Cek stok produk
        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk = '$id_produk'");
        $produk = $ambil->fetch_assoc();
        $stok = $produk['stock'];

        // Jika jumlah pembelian melebihi stok, tampilkan peringatan
        if ($jumlah > $stok) {
            echo "<script>alert('Stok produk tidak mencukupi');</script>";
        } else {
            // Jika jumlah pembelian sesuai dengan stok, kurangi stok dan tambahkan ke keranjang
            $_SESSION["keranjang"][$id_produk] = $jumlah;

            // Kurangi stok produk
            $koneksi->query("UPDATE produk SET stock = stock - $jumlah WHERE id_produk = '$id_produk'");

            echo "<script>alert('Dimsum telah masuk ke keranjang Anda');</script>";
            echo "<script>location='keranjang.php';</script>";
        }
    }
}
?>


                        <p><?php echo $detail["deskripsi_produk"]; ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>
