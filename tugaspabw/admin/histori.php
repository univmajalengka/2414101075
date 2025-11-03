<?php
// admin/histori.php
include 'auth.php'; // Penjaga sesi
include '../db.php'; // Koneksi DB

// Ambil semua data pesanan, diurutkan dari yang terbaru
$result = $koneksi->query("SELECT * FROM pesanan ORDER BY waktu_pesan DESC");

$admin_username = htmlspecialchars($_SESSION['admin_username']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Pesanan - Admin</title>
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
                    <li class="nav-item">
                        <a class="nav-link active" href="histori.php">Histori Pesanan</a>
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
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Histori Pesanan Pelanggan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-admin align-middle">
                        <thead class="text-center">
                            <tr>
                                <th>ID Pesan</th>
                                <th>Waktu Pesan</th>
                                <th>Nama Pemesan</th>
                                <th>No. HP</th>
                                <th>Tgl Kunjungan</th>
                                <th>Nama Makanan</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $row['id_pesanan'] ?></td>
                                <td><?= htmlspecialchars($row['waktu_pesan']) ?></td>
                                <td><?= htmlspecialchars($row['nama_pemesan']) ?></td>
                                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['tanggal_kunjungan']) ?></td>
                                <td><?= htmlspecialchars($row['nama_makanan']) ?></td>
                                <td class="text-end">Rp <?= number_format($row['harga_pesanan'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada histori pesanan.</td>
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