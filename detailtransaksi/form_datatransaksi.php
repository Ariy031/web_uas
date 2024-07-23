<?php
include '../login/sessionlogin.php';
include '../koneksi.php';

// Correct the query based on the actual columns in detailtransaksi table
$sql = "SELECT detailtransaksi.kodetransaksi, buku.judulbuku, detailtransaksi.tglpinjam, detailtransaksi.jumlahbuku, detailtransaksi.status
        FROM detailtransaksi
        JOIN buku ON detailtransaksi.kodebuku = buku.kodebuku";

// Execute the query
$result = $koneksi->query($sql);

// Check for query execution errors
if (!$result) {
    die("Query failed: " . $koneksi->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Read Transaksi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Daftar Transaksi</h2>
        <a href="../index.php" class="btn btn-success mb-3">KEMBALI</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jumlah Buku</th>
                    <th>Status</th>
                    <!-- Removed Tanggal Kembali since it doesn't exist -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["kodetransaksi"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["judulbuku"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["tglpinjam"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["jumlahbuku"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        // Removed Tanggal Kembali since it doesn't exist
                        echo "<td><a href='edit.php?kodetransaksi=" . urlencode($row["kodetransaksi"]) . "' class='btn btn-warning'>Edit</a> 
                            <a href='hapus.php?kodetransaksi=" . urlencode($row["kodetransaksi"]) . "' class='btn btn-danger'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>"; // Adjusted colspan to 6
                }
                $koneksi->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
