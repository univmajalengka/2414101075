<?php
// admin/auth.php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Jika belum login, tendang kembali ke halaman login.php
    header('Location: login.php');
    exit;
}
?>