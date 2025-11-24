<?php include 'inc/header.php'; ?>
<?php
include 'inc/db.php';
$paket_id = isset($_GET['paket']) ? intval($_GET['paket']) : 0;
$paket = null;
if($paket_id){
  $stmt = $mysqli->prepare("SELECT id,title,price FROM paket WHERE id=?");
  $stmt->bind_param('i',$paket_id);
  $stmt->execute();
  $paket = $stmt->get_result()->fetch_assoc();
  $stmt->close();
}

$ok=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
  $nama = trim($_POST['nama']);
  $paket_id = intval($_POST['paket_id']);
  $tanggal = $_POST['tanggal'];
  $jumlah = intval($_POST['jumlah']);
  $phone = trim($_POST['phone']);
  $email = trim($_POST['email']);
  $stmt = $mysqli->prepare("INSERT INTO booking (nama,paket_id,tanggal,jumlah,phone,email) VALUES(?,?,?,?,?,?)");
  $stmt->bind_param('sisiis', $nama, $paket_id, $tanggal, $jumlah, $phone, $email);
  if($stmt->execute()) $ok=true;
  $stmt->close();
}
?>

<div class="row">
  <div class="col-md-8">
    <h3>Form Pemesanan</h3>

    <?php if($ok): ?>
      <div class="alert alert-success">Terima kasih — pesanan Anda telah tercatat. Silakan cek admin untuk konfirmasi.</div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input name="nama" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Paket</label>
        <select name="paket_id" class="form-select" required>
          <option value="">Pilih paket</option>
          <?php
          $r = $mysqli->query("SELECT id,title FROM paket");
          while($row=$r->fetch_assoc()){
            $sel = ($paket_id && $paket_id==$row['id'])?'selected':'';
            echo "<option value=\"{$row['id']}\" $sel>".htmlspecialchars($row['title'])."</option>";
          }
          $r->free();
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Jumlah Orang</label>
        <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
      </div>

      <div class="mb-3">
        <label class="form-label">No. Telp</label>
        <input name="phone" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control">
      </div>

      <button class="btn btn-primary">Kirim Pesanan</button>
    </form>
  </div>

  <div class="col-md-4">
    <h5>Kontak & Info</h5>
    <p>Telepon: 083826551729<br>Email: rizkimuhamadaminudin123@gmail.com</p>
  </div>
</div>

<?php include 'inc/footer.php'; ?>
