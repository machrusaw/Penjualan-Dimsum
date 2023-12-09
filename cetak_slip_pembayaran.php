<?php
session_start();

include "koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="3.png">

    <title>Cetak Laporan Pembayaran</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">

    <link href="./assets/style.css" rel="stylesheet">
	<style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap');
        {
            margin:0;
            padding:0;
            font-family: 'Montserrat', sans-serif;
            font-size:6pt;
            color:#000;
        }
        body
        {
            
            width:100%;
            font-family: 'Montserrat', sans-serif;
            font-size:6pt;
            margin:0;
            padding:0;
        }
         
        p
        {
            margin:0;
            padding:0;
            margin-left: 0px;
        }
         
        #wrapper
        {
            width:44mm;
            margin:0 0mm;
        }
        
        #main {
    float:left;
    width:0mm;
    background:#ffffff;
    padding:0mm;
}
 
#sidebar {
    float:right;
    width:0mm;
    background:#ffffff;
    padding:0mm;
} 
         
        .page
        {
            height:200mm;
            width:44mm;
            page-break-after:always;
        }
 
        table
        {
            /** border-left: 1px solid #fff;
            border-top: 1px solid #fff; **/
            font-family: arial; 
            border-spacing:0;
            border-collapse: collapse; 
             
        }
         
        table td 
        {
            /**border-right: 1px solid #fff;
            border-bottom: 1px solid #fff;**/
            padding: 2mm;
            
        }
         
        table.heading
        {
            height:0mm;
            margin-bottom: 1px;
        }
         
        h1.heading
        {
            font-size:6pt;
            color:#000;
            font-weight:normal;
            font-style: italic;
            
            
        }
         
        h2.heading
        {
            font-size:6pt;
            color:#000;
            font-weight:normal;
        }
         
        hr
        {
            color:#ccc;
            background:#ccc;
        }
         
        #invoice_body
        {
            height: auto;
        }
         
        #invoice_body , #invoice_total
        {   
            width:100%;
        }
        #invoice_body table , #invoice_total table
        {
            width:100%;
            /** border-left: 1px solid #ccc;
            border-top: 1px solid #ccc; **/
     
            border-spacing:0;
            border-collapse: collapse; 
             
            margin-top:0mm;
        }
         
        #invoice_body table td , #invoice_total table td
        {
            text-align:center;
            font-size:8pt;
            /** border-right: 1px solid black;
            border-bottom: 1px solid black;**/
            padding:0 0;
            font-weight: normal;
        }
        
        #invoice_head table td
        {
            text-align:left;
            font-size:8pt;
            /** border-right: 1px solid black;
            border-bottom: 1px solid black;**/
            padding:0 0;
            font-weight: normal;
        }
         
        #invoice_body table td.mono  , #invoice_total table td.mono
        {
            text-align:right;
            padding-right:0mm;
            font-size:6pt;
            border: 1px solid white;
            font-weight: normal;
        }
         
        #footer
        {   
            width:44mm;
            margin:0 2mm;
            padding-bottom:1mm;
        }
        #footer table
        {
            width:100%;
            /** border-left: 1px solid #ccc;
            border-top: 1px solid #ccc; **/
             
            background:#eee;
             
            border-spacing:0;
            border-collapse: collapse; 
        }
        #footer table td
        {
            width:25%;
            text-align:center;
            font-size:8pt;
            /** border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;**/
        }
        @media print{
			#no-print{
				display: none;
			}
		}
    </style>
	
</head>
<body><center><font face="Montserrat" color="red" size="5">YUMSUM UTM</font></center>
<h7><b><center>Universitas Trunojoyo Madura</center></b></h7><br>

<?php
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan WHERE pembelian.id_pembelian='$_GET[id]'");
$detail = $ambil->fetch_assoc();
?>

<?php

$idpelangganyangbeli = $detail["id_pelanggan"];
$idpelangganyanglogin = $_SESSION["pelanggan"]["id_pelanggan"];

if ($idpelangganyangbeli !== $idpelangganyanglogin) 
{
    echo "<script>alert('jangan mengganti id pelanggan');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}

?>
<table>
    <tr>
        <td>No.Telp<br>
        Tgl.Pembelian</td>
        <td>: 0822 5726 5681<br>
        : <?php echo $detail['tanggal_pembelian']; ?></td>
    </tr>
</table>
<div style="border-bottom:1px dashed black;">
</div>
<table>
    <?php $nomor = 1; ?>
    <?php $ambil = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'"); ?>
        <?php while ($pecah = $ambil->fetch_assoc()) { ?>
	<tr>
        <td><?php echo $nomor; ?>.</td>
		<td><?php echo $pecah['nama']; ?><br><?php echo number_format($pecah['harga']); ?> x <?php echo $pecah['jumlah']; ?></td>
        <td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
    </tr>
        <?php $nomor++; ?>
    <?php
}?>
</table>
<div style="border-bottom:1px dashed black;">
</div>
<table>
    <tr>
        <td></td>
        <td align="right">Total :<br>Pembayaran :</td>
        <td>Rp. <?php echo number_format($detail['total_pembelian']); ?><br>Transfer</td>
    </tr>
</table>
<br>
<br>
<table>
	<tr>
		<td></td>
		<td width="500">
			<p><center>Terimakasih Telah Memesan<br>Dimsum yang sudah dibeli tidak bisa ditukar / dikembalikan<br> 
                ===<?php echo date('d/m/Y'); ?>===</center></p>
			
		</td>
	</tr>
</table>

<a href="#" class="btn btn-success" id="no-print" onclick="window.print();" style="background: #F63724">Cetak/Print</a>
<a href="riwayat.php" class="btn btn-default" id="no-print"><b>Kembali</a>
</body>
</html>

