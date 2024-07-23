<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'perpustakaan';

$koneksi = new mysqli($host, $user, $password, $dbname);

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}
?>