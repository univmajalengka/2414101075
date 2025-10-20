<?php
include 'db.php';
session_start();

// Ambil data makanan dari database
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$query = "SELECT * FROM makanan";
if ($kategori) {
    $query .= " WHERE kategori='$kategori'";
}
$result = $koneksi->query($query);

// Inisialisasi keranjang
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tambah ke keranjang
if (isset($_POST['tambah'])) {
    $id = $_POST['id'];
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Makan Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card img { height: 180px; object-fit: cover; }
        footer { background: #212529; color: white; padding: 20px 0; text-align: center; }
        .navbar-brand { font-weight: bold; color: #ff4d4d !important; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">Warung Makan</a>
    <div class="ms-auto">
        <a href="cart.php" class="btn btn-warning">🛒 Keranjang 
            <span class="badge bg-danger"><?= array_sum($_SESSION['cart']) ?></span>
        </a>
    </div>
</nav>

<!-- Jumbotron -->
<div class="p-5 mb-4 bg-light rounded-3 text-center">
    <h1 class="display-5 fw-bold">Selamat Datang di Warung Makan Rizki 🍽️</h1>
    <p class="fs-5">Nikmati makanan lezat dengan pemesanan cepat dan mudah.</p>
</div>

<!-- Tombol Kategori -->
<div class="container text-center mb-4">
    <a href="index.php" class="btn btn-outline-dark">Semua</a>
    <a href="index.php?kategori=Makanan" class="btn btn-outline-danger">Makanan</a>
    <a href="index.php?kategori=Minuman" class="btn btn-outline-primary">Minuman</a>
</div>

<!-- Card Makanan -->
<div class="container">
    <div class="row g-4">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="img/<?= $row['gambar'] ?>" class="card-img-top">
                    <div class="card-body text-center">
                        <h5><?= $row['nama'] ?></h5>
                        <p>Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="tambah" class="btn btn-success btn-sm">Tambah ke Keranjang</button>
                            <button type="button" class="btn btn-primary btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#beliModal"
                                data-id="<?= $row['id'] ?>" data-nama="<?= $row['nama'] ?>" data-harga="<?= $row['harga'] ?>">
                                Beli Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Modal Pembelian -->
<div class="modal fade" id="beliModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="nota.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title">Form Pembelian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_makanan" id="id_makanan">
          <div class="mb-3">
            <label>Nama Pemesan</label>
            <input type="text" name="nama_pemesan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Tanggal Kunjungan</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Nama Makanan</label>
            <input type="text" id="nama_makanan" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label>Harga</label>
            <input type="text" id="harga_makanan" class="form-control" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Cetak Nota</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Footer -->
<footer>
  <p>&copy; <?= date('Y') ?> Warung Makan Online | Dibuat dengan ❤️ di Indonesia</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const beliModal = document.getElementById('beliModal')
beliModal.addEventListener('show.bs.modal', event => {
  const button = event.relatedTarget
  document.getElementById('id_makanan').value = button.getAttribute('data-id')
  document.getElementById('nama_makanan').value = button.getAttribute('data-nama')
  document.getElementById('harga_makanan').value = 'Rp ' + new Intl.NumberFormat('id-ID').format(button.getAttribute('data-harga'))
})
</script>

</body>
</html>
