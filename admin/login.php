<?php

session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../3.png">
    <title>Login</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

<style>
   body{
    background: #FFF3F3;
    background-repeat:repeat;
    background-size: 60px;
    } 
.row{
    padding-top: 190px;
}
.gambar{
    font-color:black;
    box-shadow: 0px 0px 10px  black;
    background: #F4EFE5;
    background-size: cover;
    background-attachment: fixed;
}

.img-wrapper img{
    height: 100px;
    width: 240px;
}


</style>

</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                 <div class="gambar">
                    <div class="panel-heading">
                        <div class="img-wrapper">
                            <center><img src="../logo.png"></center>
                        </div>
                        <strong>Silahkan Login dibawah ini:</strong>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <label>Username</label>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" class="form-control" name="username">
                            </div>
                            <label>Password</label>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox">Ingat saya
                                </label>
                            </div>
                        <button class="btn btn-primary" name="login" style="background : #F63724">Login</button>

                    </form>
                    
    <?php
if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password_encrypted = md5($password);

    $ambil = $koneksi->query("SELECT * FROM admin WHERE username='$username'
            AND password ='$password_encrypted'");
    $yangcocok = $ambil->num_rows;
    if ($yangcocok == 1) {
        $_SESSION['admin'] = $ambil->fetch_assoc();
        echo "<div class='alert alert-info'>Login Berhasil</div>";
        echo "<meta http-equiv='refresh' content='1;url=index.php'>";
    }
    else {
        echo "<div class='alert alert-danger'>Login Gagal</div>";
        echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    }
}
?>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>