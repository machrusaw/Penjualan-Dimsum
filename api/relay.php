<?php
declare(strict_types=1);

// pastikan relative include bekerja dari root
chdir(__DIR__ . '/..');
$script = $_GET['script'] ?? '';

// whitelist file yang boleh dieksekusi langsung
$allowed = [
  'login.php',
  'register.php',
  'logout.php',
  'admin/login.php',
  // tambahkan file PHP lain yang memang ingin diakses langsung via URL
];

// normalize path & cegah traversal
$script = str_replace(['..', '\\'], ['', '/'], $script);

if (!in_array($script, $allowed, true) || !is_file($script)) {
  http_response_code(404);
  echo "Not found";
  exit;
}

// opsional: koneksi
if (file_exists('koneksi.php')) require_once 'koneksi.php';

require $script;
