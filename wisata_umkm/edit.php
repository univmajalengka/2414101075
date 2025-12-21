<?php
include 'koneksi.php';

// Validasi ID
if (!isset($_GET['id'])) {
    echo "<script>
            alert('ID pesanan tidak ditemukan!');
            window.location='modifikasi_pesanan_wisata.php';
          </script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data lama
$query = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>
            alert('Data pesanan tidak ditemukan!');
            window.location='modifikasi_pesanan_wisata.php';
          </script>";
    exit;
}

// Pecah pelayanan jadi array
$pelayanan = explode(",", $data['pelayanan']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pesanan Wisata</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            margin: 0;
        }

        header {
            background: #f6c23e;
            color: #000;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 800px;
            background: white;
            margin: 30px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .checkbox-group label {
            display: inline-block;
            margin-right: 15px;
            font-weight: normal;
        }

        .result {
            background: #fff9e6;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .btn-submit {
            width: 100%;
            background: #f6c23e;
            color: #000;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #dda20a;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2c7be5;
            text-decoration: none;
            font-weight: bold;
        }
    </style>

    <script>
        function hitungTotal() {
            let hari = document.getElementById("hari").value || 0;
            let peserta = document.getElementById("peserta").value || 0;
            let layanan = document.querySelectorAll('input[name="pelayanan[]"]:checked');
            let harga = 0;

            layanan.forEach(item => {
                harga += parseInt(item.value);
            });

            document.getElementById("harga").value = harga;
            document.getElementById("total").value = hari * peserta * harga;
        }
    </script>
</head>

<body>

<header>
    <h1>Edit Pesanan Paket Wisata</h1>
</header>

<div class="container">
    <h2>Ubah Data Pesanan</h2>

    <form method="post" action="update.php">

        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div class="form-group">
            <label>Nama Pemesan</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
        </div>

        <div class="form-group">
            <label>No. HP / Telp</label>
            <input type="text" name="hp" value="<?= $data['hp'] ?>" required>
        </div>

        <div class="form-group">
            <label>Tanggal Pesan</label>
            <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required>
        </div>

        <div class="form-group">
            <label>Waktu Perjalanan (Hari)</label>
            <input type="number" id="hari" name="hari" value="<?= $data['hari'] ?>" min="1" oninput="hitungTotal()" required>
        </div>

        <div class="form-group">
            <label>Jumlah Peserta</label>
            <input type="number" id="peserta" name="peserta" value="<?= $data['peserta'] ?>" min="1" oninput="hitungTotal()" required>
        </div>

        <div class="form-group checkbox-group">
            <label>Pelayanan</label>
            <label>
                <input type="checkbox" name="pelayanan[]" value="1000000"
                <?= in_array("1000000", $pelayanan) ? "checked" : "" ?>
                onclick="hitungTotal()"> Penginapan
            </label>

            <label>
                <input type="checkbox" name="pelayanan[]" value="1200000"
                <?= in_array("1200000", $pelayanan) ? "checked" : "" ?>
                onclick="hitungTotal()"> Transportasi
            </label>

            <label>
                <input type="checkbox" name="pelayanan[]" value="500000"
                <?= in_array("500000", $pelayanan) ? "checked" : "" ?>
                onclick="hitungTotal()"> Makan
            </label>
        </div>

        <div class="result">
            <div class="form-group">
                <label>Harga Paket</label>
                <input type="text" id="harga" name="harga" value="<?= $data['harga'] ?>" readonly>
            </div>

            <div class="form-group">
                <label>Total Tagihan</label>
                <input type="text" id="total" name="total" value="<?= $data['total'] ?>" readonly>
            </div>
        </div>

        <button type="submit" class="btn-submit">Update Pesanan</button>
    </form>

    <a href="modifikasi_pesanan_wisata.php" class="btn-back">⬅ Kembali</a>
</div>

<script>
    hitungTotal(); // hitung ulang saat halaman dibuka
</script>

</body>
</html>
