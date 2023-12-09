<!DOCTYPE html>
<html>
<head>
    <title>Log Aktivitas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h2>Log Aktivitas</h2>

    <table>
        <tr>
            <th>Tanggal</th>
            <th>Aktivitas</th>
            <th>Pengguna</th>
        </tr>

        <?php
        // Koneksi ke database
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "dimsum";
        $conn = mysqli_connect($host, $username, $password, $database);

        // Cek koneksi
        if (!$conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

        // Query untuk mendapatkan data log dari tabel log_aktivitas
        $query = "SELECT tanggal, aktivitas, pengguna FROM log_aktivitas ORDER BY tanggal DESC";
        $result = mysqli_query($conn, $query);

        // Tampilkan data log dalam tabel
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["tanggal"] . "</td>";
                echo "<td>" . $row["aktivitas"] . "</td>";
                echo "<td>" . $row["pengguna"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Tidak ada data log</td></tr>";
        }

        // Tutup koneksi
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
