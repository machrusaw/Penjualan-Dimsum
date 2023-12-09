<?php
// Menghubungkan ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'toko_online';
$koneksi = mysqli_connect($host, $user, $password, $database);

// Memeriksa koneksi database
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Memeriksa apakah tombol "Tambah" ditekan
if (isset($_POST['tambah_stok'])) {
    // Mengambil nilai produk_id dari formulir
    $produk_id = $_POST['produk_id'];

    // Menjalankan stored procedure update_stock dengan parameter produk_id
    $query = "CALL update_stock($produk_id)";
    $result = mysqli_query($koneksi, $query);

    // Memeriksa hasil eksekusi stored procedure
    if ($result) {
        // Mengambil pesan hasil dari stored procedure
        $row = mysqli_fetch_assoc($result);
        $message = $row['message'];

        // Menampilkan pesan berhasil
        echo "<p>$message</p>";
        echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=produk'>";
    } else {
        // Menampilkan pesan error jika eksekusi stored procedure gagal
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Menutup koneksi database
mysqli_close($koneksi);
?>
