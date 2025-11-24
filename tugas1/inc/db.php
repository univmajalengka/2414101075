<?php
// inc/db.php
$host = '127.0.0.1';
$db   = 'wisata_db';
$user = 'root';
$pass = ''; // default XAMPP
$charset = 'utf8mb4';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die('Koneksi gagal: ' . $mysqli->connect_error);
}
$mysqli->set_charset($charset);
