<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) 
{
    echo "<script>alert('Anda Harus Login');</script>";
    echo "<script>location='login.php';</script>";
    header('location:login.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="../logo.png">
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <style type="text/css">
       #wrapper{
        background-color: #F4EFE5;
       }
   </style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0; background : #F4EFE5">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse" >
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="background:#F4EFE5 "><img src="../logo.png" alt="" style="width:170px; height : 60px"></a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;">&nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation" >
            <div class="sidebar-collapse" >
                <ul class="nav" id="main-menu">
				<li class="text-center" style="background : #F63724" >
					</li>
				
					
                    <li style="background : #F63724"><a href="index.php"style="background:#F4EFE5; color : black"><i class="fa fa-dashboard" ></i>Home</a></li>
                    <li style="background : #F63724"><a href="index.php?halaman=produk" style="background:#F4EFE5; color : black "><i class="fa fa-qrcode fa-1x"></i>Produk</a></li>
                    <li style="background : #F63724"><a href="index.php?halaman=pembelian" style="background:#F4EFE5;color : black "><i class="fa fa-shopping-cart"></i>Pembelian</a></li>
                    <li style="background : #F63724"><a href="index.php?halaman=laporan_pembelian" style="background:#F4EFE5;color : black "><i class="fa fa-file"></i>Laporan Pembelian</a></li>
                    <li style="background : #F63724"><a href="index.php?halaman=pelanggan" style="background:#F4EFE5;color : black "><i class="fa fa-user"></i>Pelanggan</a></li>
                    <li style="background : #F63724"><a href="index.php?halaman=log" style="background:#F4EFE5;color : black "><i class="fa fa-user"></i>Log Aktivitas</a></li>
                    <li style="background : #F63724"><a href="index.php?halaman=logout" style="background:#F4EFE5;color : black "><i class="fa fa-sign-out"></i>Logout</a></li>
                   </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <?php
if (isset($_GET['halaman'])) {
    if ($_GET['halaman'] == "produk") {
        include 'produk.php';
    }
    elseif ($_GET['halaman'] == "pembelian") {
        include 'pembelian.php';
    }
    elseif ($_GET['halaman'] == "pelanggan") {
        include 'pelanggan.php';
    }
    elseif ($_GET['halaman'] == "detail") {
        include 'detail.php';
    }
    elseif ($_GET['halaman'] == "tambahproduk") {
        include 'tambahproduk.php';
    }
    elseif ($_GET['halaman'] == "hapusproduk") {
        include 'hapusproduk.php';
    }
    elseif ($_GET['halaman'] == "ubahproduk") {
        include 'ubahproduk.php';
    }
    elseif ($_GET['halaman'] == "logout") {
        include 'logout.php';
    }
    elseif ($_GET['halaman'] == "tambahpelanggan") {
        include 'tambahpelanggan.php';
    }
    elseif ($_GET['halaman'] == "hapuspelanggan") {
        include 'hapuspelanggan.php';
    }
    elseif ($_GET['halaman'] == "pembayaran") {
        include 'pembayaran.php';
    }
    elseif ($_GET['halaman'] == "laporan_pembelian") {
        include 'laporan_pembelian.php';
    }
    elseif ($_GET['halaman'] == "log") {
        include 'log.php';
    }
    elseif ($_GET['halaman'] == "tambah1lusin") {
        include 'tambah1lusin.php';
    }
}
else {
    include 'home.php';
}
?>
            </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- MORRIS CHART SCRIPTS -->
     <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
