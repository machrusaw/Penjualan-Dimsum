<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$DB_HOST = "mmkf8p.h.filess.io";   // contoh: db-123.filess.cloud
$DB_USER = "penjualanDimsum_nosegently";
$DB_PASS = "920822624806e97ffe8131bd387d81d93da3e6e5";
$DB_NAME = "penjualanDimsum_nosegently";
$DB_PORT = 3307;                 // biasanya 3306, cek di Filess

$koneksi = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
$koneksi->set_charset('utf8mb4');
?>
