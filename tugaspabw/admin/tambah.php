<?php
// admin/tambah.php
include 'auth.php';
include '../db.php';

$error = '';
$sukses = false;

// Proses form jika di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = (int)$_POST['harga'];
    $kategori = $_POST['kategori'];
    $nama_gambar = '';

    // Validasi dasar
    if (empty($nama) || empty($harga) || empty($kategori)) {
        $error = 'Semua field (kecuali gambar) wajib diisi.';
    } elseif (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        // Proses upload gambar
        $target_dir = "../assets/img/"; // Folder upload di LUAR admin
        $nama_gambar = basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $nama_gambar;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if($check === false) {
            $error = 'File bukan gambar.';
        } elseif (file_exists($target_file)) {
            $error = 'Maaf, nama file gambar sudah ada. Silakan ganti nama file.';
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error = 'Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.';
        }

        // Jika tidak ada error, upload file
        if (empty($error)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // File berhasil di-upload, masukkan ke database
                $stmt = $koneksi->prepare("INSERT INTO makanan (nama, harga, kategori, gambar) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("siss", $nama, $harga, $kategori, $nama_gambar);
                
                if($stmt->execute()) {
                    header("Location: index.php?status=sukses"); // Redirect ke index
                    exit;
                } else {
                    $error = 'Gagal menyimpan data ke database.';
                }
            } else {
                $error = 'Maaf, terjadi error saat meng-upload file.';
            }
        }
    } else {
        $error = 'File gambar wajib di-upload.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Makanan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Kelola Makanan</a>
                    </li>
                </ul>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card form-wrapper">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Makanan</h5>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Makanan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga (cth: 25000)</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Makanan</label>
                        <input class="form-control" type="file" id="gambar" name="gambar" required>
                    </div>
                    <hr>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>