<?php
// admin/hapus.php
include 'auth.php';
include '../db.php';

$id = (int)$_GET['id'];

if ($id > 0) {
    // 1. Ambil nama file gambar sebelum dihapus dari DB
    $stmt = $koneksi->prepare("SELECT gambar FROM makanan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama_gambar = $row['gambar'];
        $file_path = "../assets/img/" . $nama_gambar;

        // 2. Hapus data dari database
        $delete_stmt = $koneksi->prepare("DELETE FROM makanan WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        
        if ($delete_stmt->execute()) {
            // 3. Jika data DB berhasil dihapus, hapus file gambar dari server
            if (!empty($nama_gambar) && file_exists($file_path)) {
                unlink($file_path);
            }
            header("Location: index.php?status=hapus");
            exit;
        }
    }
}

// Jika gagal atau ID tidak valid
header("Location: index.php?status=gagal");
exit;
?>