<?php
// 1. Sertakan koneksi database
include 'db.php';

// 2. Ambil data dari formulir (POST)
$id_makanan = isset($_POST['id_makanan']) ? (int) $_POST['id_makanan'] : 0;
$nama_pemesan = isset($_POST['nama_pemesan']) ? $_POST['nama_pemesan'] : '';
$no_hp = isset($_POST['no_hp']) ? $_POST['no_hp'] : '';
// Data dari input 'tanggal' akan disimpan ke 'tanggal_kunjungan'
$tanggal_kunjungan = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';

// 3. Ambil detail makanan dari tabel 'makanan' untuk arsip & cetak
$stmt_makanan = $koneksi->prepare("SELECT * FROM makanan WHERE id = ?");
$stmt_makanan->bind_param("i", $id_makanan);
$stmt_makanan->execute();
$result_makanan = $stmt_makanan->get_result();
$makanan = $result_makanan->fetch_assoc(); // Data makanan ada di $makanan

// 4. Simpan ke tabel 'pesanan' jika makanan ditemukan
if ($makanan) {
    // Ambil nama & harga saat ini untuk disimpan sebagai arsip
    $nama_makanan_arsip = $makanan['nama'];
    $harga_pesanan_arsip = $makanan['harga'];

    // Siapkan perintah INSERT ke tabel 'pesanan' (sesuai SQL lengkap)
    $stmt_insert = $koneksi->prepare(
        "INSERT INTO pesanan (id_makanan, nama_makanan, harga_pesanan, nama_pemesan, no_hp, tanggal_kunjungan) 
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    
    // 'isisss' = integer, string, integer, string, string, string
    $stmt_insert->bind_param(
        "isisss", 
        $id_makanan,
        $nama_makanan_arsip,
        $harga_pesanan_arsip,
        $nama_pemesan,
        $no_hp,
        $tanggal_kunjungan 
    );
    
    // Jalankan perintah simpan
    $stmt_insert->execute();
    $stmt_insert->close();
}

$stmt_makanan->close();
$koneksi->close();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nota Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Sembunyikan tombol saat print */
    @media print {
        .no-print {
            display: none;
        }
    }
    </style>
</head>

<body onload="window.print()" class="bg-light">

    <div class="container mt-5 bg-white p-4 rounded shadow" style="max-width: 500px;">
        <h3 class="text-center">🧾 Nota Pembelian</h3>
        <hr>

        <p><strong>Nama Pemesan:</strong> <?= htmlspecialchars($nama_pemesan) ?></p>
        <p><strong>No HP:</strong> <?= htmlspecialchars($no_hp) ?></p>
        <p><strong>Tanggal Kunjungan:</strong> <?= htmlspecialchars($tanggal_kunjungan) ?></p>
        <hr>

        <?php if ($makanan): // Cek apakah data makanan ditemukan ?>
        <p><strong>Nama Makanan:</strong> <?= htmlspecialchars($makanan['nama']) ?></p>
        <p><strong>Harga:</strong> Rp <?= number_format($makanan['harga'], 0, ',', '.') ?></p>
        <hr>
        <h4 class="text-end">Total: Rp <?= number_format($makanan['harga'], 0, ',', '.') ?></h4>
        <?php else: ?>
        <p class="text-danger">Error: Data makanan tidak ditemukan.</p>
        <?php endif; ?>

        <div class="text-center mt-4 no-print">
            <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>

</body>

</html>