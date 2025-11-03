<?php
// admin/edit.php
include 'auth.php';
include '../db.php';

$error = '';
$id = (int)$_GET['id'];
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Ambil data lama
$stmt = $koneksi->prepare("SELECT * FROM makanan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$makanan = $result->fetch_assoc();

if (!$makanan) {
    header('Location: index.php');
    exit;
}

// Proses form jika di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = (int)$_POST['harga'];
    $kategori = $_POST['kategori'];
    $gambar_lama = $_POST['gambar_lama'];
    $nama_gambar = $gambar_lama; // Default pakai gambar lama

    // Validasi dasar
    if (empty($nama) || empty($harga) || empty($kategori)) {
        $error = 'Semua field wajib diisi.';
    }

    // Cek jika ada upload gambar BARU
    if (isset($_FILES['gambar_baru']) && $_FILES['gambar_baru']['error'] == 0) {
        $target_dir = "../assets/img/";
        $nama_gambar = basename($_FILES["gambar_baru"]["name"]);
        $target_file = $target_dir . $nama_gambar;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["gambar_baru"]["tmp_name"]);
        if($check === false) {
            $error = 'File baru bukan gambar.';
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error = 'Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.';
        }
        
        // Jika tidak ada error, upload file baru
        if (empty($error)) {
            if (move_uploaded_file($_FILES["gambar_baru"]["tmp_name"], $target_file)) {
                // Hapus gambar lama JIKA namanya beda
                if ($gambar_lama != $nama_gambar && file_exists($target_dir . $gambar_lama)) {
                    unlink($target_dir . $gambar_lama);
                }
            } else {
                $error = 'Maaf, terjadi error saat meng-upload file baru.';
            }
        }
    }

    // Jika tidak ada error, update database
    if (empty($error)) {
        $stmt = $koneksi->prepare("UPDATE makanan SET nama = ?, harga = ?, kategori = ?, gambar = ? WHERE id = ?");
        $stmt->bind_param("sissi", $nama, $harga, $kategori, $nama_gambar, $id);
        
        if($stmt->execute()) {
            header("Location: index.php?status=sukses"); // Redirect ke index
            exit;
        } else {
            $error = 'Gagal memperbarui data ke database.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Makanan - Admin</title>
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
                <h5 class="mb-0">Form Edit Makanan</h5>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($makanan['gambar']) ?>">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Makanan</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?= htmlspecialchars($makanan['nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga"
                            value="<?= $makanan['harga'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="Makanan" <?= ($makanan['kategori'] == 'Makanan') ? 'selected' : '' ?>>Makanan
                            </option>
                            <option value="Minuman" <?= ($makanan['kategori'] == 'Minuman') ? 'selected' : '' ?>>Minuman
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label><br>
                        <img src="../assets/img/<?= htmlspecialchars($makanan['gambar']) ?>" alt=""
                            style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
                    </div>
                    <div class="mb-3">
                        <label for="gambar_baru" class="form-label">Upload Gambar Baru (Opsional)</label>
                        <input class="form-control" type="file" id="gambar_baru" name="gambar_baru">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                    </div>
                    <hr>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>