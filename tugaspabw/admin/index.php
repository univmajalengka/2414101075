<?php
// admin/index.php
include 'auth.php'; // Penjaga sesi
include '../db.php'; // Koneksi DB

// Query ini sudah benar, mengurutkan berdasarkan ID
$result = $koneksi->query("SELECT * FROM makanan ORDER BY id ASC");

$admin_username = htmlspecialchars($_SESSION['admin_username']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) != 'histori.php') ? 'active' : ''; ?>"
                            href="index.php">Kelola Makanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'histori.php') ? 'active' : ''; ?>"
                            href="histori.php">Histori Pesanan</a>
                    </li>
                </ul>

                <span class="navbar-text me-3">
                    Login sebagai: <strong><?= $admin_username ?></strong>
                </span>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data makanan berhasil disimpan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <?php if(isset($_GET['status']) && $_GET['status'] == 'hapus'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data makanan berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Makanan</h5>
                <a href="tambah.php" class="btn btn-primary btn-sm">Tambah Makanan Baru +</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-admin align-middle">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 50px;">No.</th>
                                <th>Gambar</th>
                                <th>Nama Makanan</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>

                            <?php if($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $nomor++ ?></td>

                                <td class="text-center">
                                    <img src="../assets/img/<?= htmlspecialchars($row['gambar']) ?>"
                                        alt="<?= htmlspecialchars($row['nama']) ?>">
                                </td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($row['kategori']) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Anda yakin ingin menghapus item ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data makanan.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>