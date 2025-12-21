<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Modifikasi Pesanan Wisata</title>
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
            padding: 30px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        th {
            background: #2c7be5;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: #f1f7ff;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-edit {
            background: #f6c23e;
            color: #000;
        }

        .btn-delete {
            background: #e74a3b;
            color: white;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            background: #1cc88a;
            color: white;
            padding: 10px 18px;
            border-radius: 5px;
            text-decoration: none;
        }

        @media(max-width: 768px){
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                text-align: left;
            }
            td {
                text-align: left;
                padding-left: 50%;
                position: relative;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Manajemen Pesanan Paket Wisata</h1>
    <p>UMKM Pariwisata</p>
</header>

<div class="container">
    <h2>Daftar Pesanan Wisata</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Pemesan</th>
            <th>No HP</th>
            <th>Tanggal</th>
            <th>Hari</th>
            <th>Peserta</th>
            <th>Pelayanan</th>
            <th>Total Tagihan</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY id DESC");

        if(mysqli_num_rows($query) == 0){
            echo "<tr><td colspan='9'>Belum ada data pesanan</td></tr>";
        } else {
            while($data = mysqli_fetch_assoc($query)){
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $data['nama'] ?></td>
            <td><?= $data['hp'] ?></td>
            <td><?= $data['tanggal'] ?></td>
            <td><?= $data['hari'] ?> Hari</td>
            <td><?= $data['peserta'] ?> Orang</td>
            <td><?= $data['pelayanan'] ?></td>
            <td><strong>Rp <?= number_format($data['total'],0,',','.') ?></strong></td>
            <td>
                <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-edit">Edit</a>
                <a href="hapus_pesanan.php?id=<?= $data['id'] ?>"
   onclick="return confirm('Yakin ingin menghapus pesanan ini?')"
   class="btn btn-delete">
   Hapus
</a>

                </a>
            </td>
        </tr>
        <?php }} ?>
    </table>

    <a href="index.php" class="btn-back">⬅ Kembali ke Beranda</a>
</div>

</body>
</html>
