<?php
include '../login/sessionlogin.php';
include '../koneksi.php';

// Ambil semua kode buku dari tabel buku
$sql_buku = "SELECT kodebuku FROM buku";
$result_buku = $koneksi->query($sql_buku);

// Inisialisasi array untuk menyimpan semua kode buku
$kodebuku_options = array();

if ($result_buku->num_rows > 0) {
    while ($row_buku = $result_buku->fetch_assoc()) {
        $kodebuku_options[] = $row_buku['kodebuku'];
    }
} else {
    echo "Tidak ada data buku tersedia.";
}

// Proses update data jika form dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kodetransaksi = $_POST['kodetransaksi'];
    $kodebuku = $_POST['kodebuku'];
    $tglpinjam = $_POST['tglpinjam'];
    $jumlahbuku = $_POST['jumlahbuku'];
    $status = $_POST['status'];
    $tglkembali = $_POST['tglkembali'];

    // Query untuk melakukan update data transaksi menggunakan prepared statement
    $sql_update = "UPDATE detailtransaksi SET kodebuku = ?, tglpinjam = ?, jumlahbuku = ?, status = ?, tglkembali = ? WHERE kodetransaksi = ?";
    $stmt_update = $koneksi->prepare($sql_update);
    if ($stmt_update) {
        $stmt_update->bind_param("ssssss", $kodebuku, $tglpinjam, $jumlahbuku, $status, $tglkembali, $kodetransaksi);

        if ($stmt_update->execute()) {
            echo "<div class='alert alert-success'>Record updated successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt_update->error . "</div>";
        }

        $stmt_update->close();
    } else {
        echo "<div class='alert alert-danger'>Failed to prepare statement: " . $koneksi->error . "</div>";
    }

    $koneksi->close();
}

// Ambil data transaksi berdasarkan kodetransaksi yang diberikan
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['kodetransaksi'])) {
    $kodetransaksi = $_GET['kodetransaksi'];

    $sql = "SELECT * FROM detailtransaksi WHERE kodetransaksi = ?";
    $stmt = $koneksi->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $kodetransaksi);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-warning'>Transaksi tidak ditemukan.</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Failed to prepare statement: " . $koneksi->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update Transaksi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Update Transaksi</h2>
        <?php if (isset($row)) : ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="kodetransaksi" value="<?php echo $row['kodetransaksi']; ?>">
                <div class="form-group">
                    <label>Kode Buku</label>
                    <select name="kodebuku" class="form-control" required>
                        <?php foreach ($kodebuku_options as $option) : ?>
                            <option value="<?php echo $option; ?>" <?php if ($row['kodebuku'] == $option) echo 'selected'; ?>><?php echo $option; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tglpinjam" class="form-control" value="<?php echo $row['tglpinjam']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Jumlah Buku</label>
                    <input type="number" name="jumlahbuku" class="form-control" value="<?php echo $row['jumlahbuku']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" value="<?php echo $row['status']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="tglkembali" class="form-control" value="<?php echo $row['tglkmbali']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        <?php else : ?>
            <div class="alert alert-warning">Data transaksi tidak ditemukan. Silakan kembali ke <a href="index.php">halaman utama</a>.</div>
        <?php endif; ?>
    </div>
</body>

</html>