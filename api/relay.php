<?php
declare(strict_types=1);

/**
 * Relay untuk mengeksekusi file .php mana pun di project ini,
 * dengan pengamanan traversal dan perbaikan $_SERVER agar skrip
 * target merasa dieksekusi langsung.
 */

// Pindahkan working dir ke root project agar include/require relatif tetap jalan
chdir(__DIR__ . '/..');
$projectRoot = getcwd();

// Ambil path file dari query string
$script = $_GET['script'] ?? '';
// Normalisasi: hilangkan backslash & cegah traversal
$script = str_replace('\\', '/', $script);
$script = preg_replace('#(^/)+#', '', $script);         // hapus leading slash
$resolved = realpath($projectRoot . '/' . $script);

// Validasi: harus ada, harus .php, dan HARUS berada di dalam project root (anti ../)
if (!$resolved || pathinfo($resolved, PATHINFO_EXTENSION) !== 'php' || strpos($resolved, $projectRoot) !== 0) {
  http_response_code(404);
  echo "Not found";
  exit;
}

// Opsional: batasi hanya folder tertentu (hapus komentar jika ingin whitelist yang ketat)
// $allowedPrefixes = ["$projectRoot/login.php", "$projectRoot/register.php", "$projectRoot/admin/", "$projectRoot/produk/"];
// $ok = $resolved === "$projectRoot/login.php" || str_starts_with($resolved, "$projectRoot/produk/") || str_starts_with($resolved, "$projectRoot/admin/");
// if (!$ok) { http_response_code(404); exit; }

// Perbaiki beberapa variabel server supaya skrip target nyaman
$_SERVER['SCRIPT_FILENAME'] = $resolved;
$_SERVER['SCRIPT_NAME']     = '/' . ltrim($script, '/');
$_SERVER['PHP_SELF']        = $_SERVER['SCRIPT_NAME'];
$_SERVER['REQUEST_URI']     = $_SERVER['SCRIPT_NAME'] . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '');

// Muat koneksi jika dibutuhkan secara global
if (file_exists('koneksi.php')) {
  require_once 'koneksi.php';
}

// Jalankan skrip target
require $resolved;
