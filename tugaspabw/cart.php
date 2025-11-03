<?php
include 'db.php';
session_start();

// Jika keranjang belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Hapus item dari keranjang (Ini sudah aman karena (int))
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}

// Tambah / Kurang jumlah (Ini sudah aman karena (int))
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        if ($_GET['action'] == 'tambah') {
            $_SESSION['cart'][$id]++;
        } elseif ($_GET['action'] == 'kurang' && $_SESSION['cart'][$id] > 1) {
            $_SESSION['cart'][$id]--;
        }
    }
    header("Location: cart.php");
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Keranjang - Warung Makan Rizki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .btn-sm {
        padding: 4px 8px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="index.php">← Kembali ke Beranda</a>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">🛒 Keranjang Belanja Anda</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Makanan</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                $no = 1;
                if (!empty($_SESSION['cart'])) {
                    
                    // --- PERBAIKAN KEAMANAN (Prepared Statements) ---
                    // Siapkan statement 1x di luar loop untuk efisiensi
                    $stmt = $koneksi->prepare("SELECT * FROM makanan WHERE id = ?");

                    foreach ($_SESSION['cart'] as $id => $jumlah) {
                        // Bind ID dari session dan eksekusi
                        $stmt->bind_param("i", $id); // 'i' = integer
                        $stmt->execute();
                        $result = $stmt->get_result();
                        // --- Akhir Perbaikan Keamanan ---

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $subtotal = $row['harga'] * $jumlah;
                            $total += $subtotal;
                ?>
                    <tr class="text-center">
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td>
                            <a href="cart.php?action=kurang&id=<?= $id ?>" class="btn btn-warning btn-sm">−</a>
                            <span class="mx-2"><?= $jumlah ?></span>
                            <a href="cart.php?action=tambah&id=<?= $id ?>" class="btn btn-success btn-sm">+</a>
                        </td>
                        <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        <td>
                            <a href="cart.php?hapus=<?= $id ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus item ini dari keranjang?')">🗑 Hapus</a>
                        </td>
                    </tr>
                    <?php
                        } else {
                            // Jika ID di keranjang tidak ada di DB, hapus dari session
                            unset($_SESSION['cart'][$id]);
                        }
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center text-muted'>Keranjang masih kosong</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <h4>Total: <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></h4>
            <a href="index.php" class="btn btn-secondary mt-2">← Lanjut Belanja</a>
        </div>
    </div>

</body>

</html>