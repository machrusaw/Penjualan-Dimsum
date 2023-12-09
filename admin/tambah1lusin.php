<!DOCTYPE html>
<html>
<head>
    <title>Tambah 1 Lusin Stok Produk</title>
</head>
<body>
    <h2>Tambah 1 Lusin Stok Produk</h2>
    <table>
    <form method="POST" action="proses_tambah_stok.php">
        <label>Pilih Produk : </label><br>
        <select class="form-control" name="produk_id">
        <option value="">--Pilih Status--</option>
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

            // Mengambil data produk dari database
            $query = "SELECT id_produk, nama_produk FROM produk";
            $result = mysqli_query($koneksi, $query);

            // Menampilkan opsi produk dalam select
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['id_produk'] . '">' . $row['nama_produk'] . '</option>';
            }

            // Menutup koneksi database
            mysqli_close($koneksi);
            ?>
        </select><br>

        <button class="btn btn-primary" style="background: #5cb85c" type="submit" name="tambah_stok">Tambah</button>
    </form>
    </table>
    
</body>
</html>
