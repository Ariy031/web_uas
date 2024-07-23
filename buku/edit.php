<?php
include '../login/sessionlogin.php';
include '../koneksi.php';

$kodebuku = $_POST['kodebuku'];
$judulbuku = $_POST['judulbuku'];
$isbn = $_POST['isbn'];
$kodepenulis = $_POST['kodepenulis'];
$kodepenerbit = $_POST['kodepenerbit'];
$kategorikode = $_POST['kategorikode'];
$tgterbit = $_POST['tgterbit'];
$jhhalaman = $_POST['jhhalaman'];

$sql = "UPDATE buku SET judulbuku='$judulbuku', isbn='$isbn', kodepenulis='$kodepenulis', kodepenerbit='$kodepenerbit', kodekategori='$kodekategori', tgterbit='$tgterbit', jhhalaman='$jhhalaman' 
 WHERE kodebuku='$kodebuku'";

if ($koneksi->query($sql) === TRUE) {
    header('Location: form_buku.php');
} else {
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Edit Buku</h2>
        <?php
        include '../koneksi.php';

        $kodebuku = $_GET['kodebuku'];
        $sql = "SELECT * FROM buku WHERE kodebuku='$kodebuku'";
        $result = $koneksi->query($sql);
        $row = $result->fetch_assoc();
        ?>
        <form action="proses_edit.php" method="POST">
            <input type="hidden" name="kodebuku" value="<?php echo $row['kodebuku']; ?>">
            <div class="form-group">
                <label for="judulbuku">Judul Buku</label>
                <input type="text" class="form-control" id="judulbuku" name="judulbuku" value="<?php echo $row['judulbuku']; ?>" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="ISBN" name="isbn" value="<?php echo $row['ISBN']; ?>" required>
            </div>
            <div class="form-group">
                <label for="kodepenulis">Penulis</label>
                <input type="text" class="form-control" id="kodepenulis" name="kodepenulis" value="<?php echo $row['kodepenulis']; ?>" required>
            </div>
            <div class="form-group">
                <label for="kodepenerbit">Penerbit</label>
                <input type="text" class="form-control" id="kodepenerbit" name="kodepenerbit" value="<?php echo $row['kodepenerbit']; ?>" required>
            </div>
            <div class="form-group">
                <label for="kodekategori">Kategori</label>
                <input type="text" class="form-control" id="kategorikode" name="kategorikode" value="<?php echo $row['kategorikode']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tgterbit">Tanggal Terbit</label>
                <input type="date" class="form-control" id="tgterbit" name="tgterbit" value="<?php echo $row['tgterbit']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jhhalaman">Jumlah Halaman</label>
                <input type="number" class="form-control" id="jhhalaman" name="jhhalaman" value="<?php echo $row['jhhalaman']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>

</html>