<?php
$koneksi = new mysqli("localhost", "root", "", "db_makanan");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
