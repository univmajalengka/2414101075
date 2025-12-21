<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pemesanan Paket Wisata</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            margin: 0;
        }

        header {
            background: #2c7be5;
            color: white;
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
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .checkbox-group label {
            display: inline-block;
            margin-right: 15px;
            font-weight: normal;
        }

        .result {
            background: #f1f7ff;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .result input {
            background: #e9f2ff;
            font-weight: bold;
        }

        .btn-submit {
            width: 100%;
            background: #1cc88a;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #17a673;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2c7be5;
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .container {
                margin: 15px;
                padding: 20px;
            }
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

            let total = hari * peserta * harga;

            document.getElementById("harga").value = harga;
            document.getElementById("total").value = total;
        }
    </script>
</head>

<body>

<header>
    <h1>Pemesanan Paket Wisata</h1>
    <p>UMKM Pariwisata</p>
</header>

<div class="container">
    <h2>Form Pemesanan</h2>

    <form action="proses_simpan.php" method="post">

        <div class="form-group">
            <label>Nama Pemesan</label>
            <input type="text" name="nama" required>
        </div>

        <div class="form-group">
            <label>No. HP / Telp</label>
            <input type="text" name="hp" required>
        </div>

        <div class="form-group">
            <label>Tanggal Pesan</label>
            <input type="date" name="tanggal" required>
        </div>

        <div class="form-group">
            <label>Waktu Perjalanan (Hari)</label>
            <input type="number" id="hari" name="hari" min="1" oninput="hitungTotal()" required>
        </div>

        <div class="form-group">
            <label>Jumlah Peserta</label>
            <input type="number" id="peserta" name="peserta" min="1" oninput="hitungTotal()" required>
        </div>

        <div class="form-group checkbox-group">
            <label>Pelayanan</label>
            <label><input type="checkbox" name="pelayanan[]" value="1000000" onclick="hitungTotal()"> Penginapan (Rp 1.000.000)</label>
            <label><input type="checkbox" name="pelayanan[]" value="1200000" onclick="hitungTotal()"> Transportasi (Rp 1.200.000)</label>
            <label><input type="checkbox" name="pelayanan[]" value="500000" onclick="hitungTotal()"> Makan (Rp 500.000)</label>
        </div>

        <div class="result">
            <div class="form-group">
                <label>Harga Paket Perjalanan</label>
                <input type="text" id="harga" name="harga" readonly>
            </div>

            <div class="form-group">
                <label>Jumlah Tagihan</label>
                <input type="text" id="total" name="total" readonly>
            </div>
        </div>

        <button type="submit" class="btn-submit">Simpan Pesanan</button>
    </form>

    <a href="index.php" class="btn-back">⬅ Kembali ke Beranda</a>
</div>

</body>
</html>
