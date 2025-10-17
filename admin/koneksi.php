<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$name = getenv('DB_NAME') ?: 'test';
$port = (int)(getenv('DB_PORT') ?: 3306);

$koneksi = new mysqli($host, $user, $pass, $name, $port);
$koneksi->set_charset('utf8mb4');
