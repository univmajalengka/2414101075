<?php
// admin/paksa_reset.php
// Skrip ini akan MEMAKSA update data admin
include '../db.php';

// Data login baru yang Anda inginkan
$new_username = 'rizki';
$new_password = 'rizki123';
$admin_id_to_reset = 1; // Kita asumsikan ID admin Anda adalah 1

// Enkripsi password baru dengan BCRYPT
$new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

if (!$new_password_hash) {
    die("Gagal membuat hash password. Cek versi PHP Anda.");
}

// Update data di database
$stmt = $koneksi->prepare("UPDATE admin SET username = ?, password = ? WHERE id = ?");
$stmt->bind_param("ssi", $new_username, $new_password_hash, $admin_id_to_reset);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "<h1>SUKSES BESAR!</h1>";
        echo "<p>Data admin di ID 1 telah berhasil di-update.</p>";
        echo "<p>Username baru: <strong>$new_username</strong></p>";
        echo "<p>Password baru: <strong>$new_password</strong></p>";
        echo "<hr>";
        echo "<p style='color:green;'>Silakan coba login lagi di halaman <a href='login.php'>login.php</a>.</p>";
        echo "<p style='color:red; font-weight:bold;'>PENTING: Segera HAPUS file 'paksa_reset.php' ini dari server Anda!</p>";
    } else {
        echo "<h1>GAGAL (Query Berhasil, Tapi 0 Baris Terupdate)</h1>";
        echo "<p>Perintah SQL berhasil dijalankan, tapi tidak ada baris (row) dengan <strong>ID = 1</strong> di tabel 'admin' Anda.</p>";
        echo "<p>Silakan cek phpMyAdmin untuk melihat ID admin Anda yang benar dan ubah angka <strong>$admin_id_to_reset = 1;</strong> di kode ini, lalu jalankan lagi.</p>";
    }
} else {
    echo "<h1>GAGAL EKSEKUSI</h1>";
    echo "<p>Terjadi kesalahan saat mengupdate database: " . $stmt->error . "</p>";
}

$stmt->close();
$koneksi->close();
?>