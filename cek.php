<?php
// jika belum login

session_start();
if (!isset($_SESSION['log'])) {
    header('location:login.php');
    exit;
}

?>