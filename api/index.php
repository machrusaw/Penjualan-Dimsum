<?php
declare(strict_types=1);

// Stabilkan working dir ke root project agar include/require lama tetap jalan:
chdir(__DIR__ . '/..');
$_SERVER['DOCUMENT_ROOT'] = getcwd();

// Timezone lokal (opsional)
date_default_timezone_set('Asia/Jakarta');

// Jika aplikasi kamu biasa me-require koneksi di entry point, aman untuk require di sini.
// (Kalau index.php kamu sudah include koneksi.php sendiri, baris ini boleh dihapus agar tidak dobel.)
if (file_exists('koneksi.php')) {
  require_once 'koneksi.php';
}

// Teruskan request ke entry point lama kamu.
// Biasanya proyek PHP klasik punya 'index.php' di root yang melakukan routing sendiri.
require_once 'index.php';
