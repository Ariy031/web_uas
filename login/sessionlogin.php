<?php
session_start(); // Start the session

if (!isset($_SESSION['id_user'])) {
    header("Location:../login/login.php"); // Redirect to login page if not logged in
    exit();
}
?>