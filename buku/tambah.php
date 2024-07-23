<?php
include '../login/sessionlogin.php';
include '../koneksi.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if all inputs are set
if (isset($_POST['judulbuku'], $_POST['isbn'], $_POST['kodepenulis'], 
    $_POST['kodepenerbit'], $_POST['kodekategori'], $_POST['tglterbit'], $_POST['jmlhhalaman'])) {

    $judulbuku = $_POST['judulbuku'];
    $isbn = $_POST['isbn'];
    $kodepenulis = $_POST['kodepenulis'];
    $kodepenerbit = $_POST['kodepenerbit'];
    $kodekategori = $_POST['kodekategori'];
    $tglterbit = $_POST['tglterbit'];
    $jmlhhalaman = $_POST['jmlhhalaman'];

    // Use prepared statements to prevent SQL injection
    $stmt = $koneksi->prepare("INSERT INTO buku (judulbuku, isbn, kodepenulis, kodepenerbit, kodekategori, tglterbit, jmlhhalaman) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissi", $judulbuku, $isbn, $kodepenulis, $kodepenerbit, $kodekategori, $tglterbit, $jmlhhalaman);

    if ($stmt->execute()) {
        header('Location: form_buku.php');
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error: Data tidak lengkap.";
}

$koneksi->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Buku</h2>
        <form action="create.php" method="POST">
            <div class="form-group">
                <label for="judulbuku">Judul Buku</label>
                <input type="text" class="form-control" id="judulbuku" name="judulbuku" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <div class="form-group">
                <label for="kodepenulis">Penulis</label>
                <select class="form-control" id="kodepenulis" name="kodepenulis" required>
                    <option value="">Pilih Penulis</option>
                    <?php
                    include '../koneksi.php';
                    $result = $koneksi->query("SELECT kodepenulisan, namapenulis FROM penulis");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['kodepenulisan'] . "'>" . $row['namapenulis'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="kodepenerbit">Penerbit</label>
                <select class="form-control" id="kodepenerbit" name="kodepenerbit" required>
                    <option value="">Pilih Penerbit</option>
                    <?php
                    $result = $koneksi->query("SELECT kodepenerbit, namapenerbit FROM penerbit");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['kodepenerbit'] . "'>" . $row['namapenerbit'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="kodekategori">Kategori</label>
                <input type="text" class="form-control" id="kodekategori" name="kodekategori" required>
            </div>
            <div class="form-group">
                <label for="tglterbit">Tanggal Terbit</label>
                <input type="date" class="form-control" id="tglterbit" name="tglterbit" required>
            </div>
            <div class="form-group">
                <label for="jmlhhalaman">Jumlah Halaman</label>
                <input type="number" class="form-control" id="jmlhhalaman" name="jmlhhalaman" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>
