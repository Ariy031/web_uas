<?php
include '../login/sessionlogin.php';
include '../koneksi.php';

// Mengecek apakah parameter 'kodetransaksi' ada dalam URL
if (isset($_GET['kodetransaksi'])) {
    $kodetransaksi = $_GET['kodetransaksi'];

    // Validasi input
    if (empty($kodetransaksi)) {
        echo "Kode transaksi tidak valid.";
        exit;
    }

    // Menghapus data dari tabel detailtransaksi terlebih dahulu
    $sql_delete_detail = "DELETE FROM detailtransaksi WHERE kodetransaksi = ?";
    $stmt_detail = $koneksi->prepare($sql_delete_detail);
    if ($stmt_detail) {
        $stmt_detail->bind_param("s", $kodetransaksi);

        if ($stmt_detail->execute()) {
            // Menghapus data dari tabel mastertransaksi
            $sql_delete_master = "DELETE FROM mastertransaksi WHERE kodetransaksi = ?";
            $stmt_master = $koneksi->prepare($sql_delete_master);
            if ($stmt_master) {
                $stmt_master->bind_param("s", $kodetransaksi);

                if ($stmt_master->execute()) {
                    echo "Data transaksi dengan kode $kodetransaksi berhasil dihapus.";
                } else {
                    echo "Gagal menghapus data dari tabel mastertransaksi: " . $stmt_master->error;
                }

                $stmt_master->close();
            } else {
                echo "Gagal menyiapkan statement untuk tabel mastertransaksi: " . $koneksi->error;
            }
        } else {
            echo "Gagal menghapus data dari tabel detailtransaksi: " . $stmt_detail->error;
        }

        $stmt_detail->close();
    } else {
        echo "Gagal menyiapkan statement untuk tabel detailtransaksi: " . $koneksi->error;
    }
} else {
    echo "Parameter kodetransaksi tidak ditemukan.";
}

$koneksi->close();
?>
