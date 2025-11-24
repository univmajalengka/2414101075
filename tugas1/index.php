<?php include 'inc/header.php'; ?>
<!-- Banner -->
<div class="header-banner mb-3">
  <img src="assets/images/curug3.png" class="img-fluid w-100" style="height:280px; object-fit:cover; border-bottom:6px solid #ff9800;">
</div>

<!-- Short intro and video + gallery side-by-side -->
<div class="row">
  <div class="col-md-8">
    <h2>Selamat Datang di Wisata Majalengka</h2>
    <p>Promo paket, kegiatan dan pengalaman wisata terbaik di Majalengka.</p>

    <h4 id="galeri" class="mt-4">Foto Kegiatan & Spot Wisata</h4>
    <div class="row g-2">
      <div class="col-6 col-md-3"><img src="assets/images/sawah.jpg" class="img-fluid rounded"></div>
      <div class="col-6 col-md-3"><img src="assets/images/curug kapakuda.png" class="img-fluid rounded"></div>
      <div class="col-6 col-md-3"><img src="assets/images/curug1.jpg" class="img-fluid rounded"></div>
      <div class="col-6 col-md-3"><img src="assets/images/curug2.jpg" class="img-fluid rounded"></div>
    </div>
  </div>

  <div class="col-md-4">
    <h4 id="video">Video Promosi</h4>
    <div class="ratio ratio-16x9 my-2" style="max-width:100%">
      <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
    </div>
  </div>
</div>

<hr>

<h3 id="paket" class="mt-2">Paket Populer</h3>
<div class="row">
<?php
include 'inc/db.php';
$res = $mysqli->query("SELECT * FROM paket ORDER BY created_at DESC");
while($p = $res->fetch_assoc()):
?>
  <div class="col-md-6 mb-3">
    <div class="card">
      <?php if($p['image']): ?>
        <img src="<?=htmlspecialchars($p['image'])?>" class="card-img-top" style="height:200px; object-fit:cover;">
      <?php endif; ?>
      <div class="card-body">
        <h5 class="card-title"><?=htmlspecialchars($p['title'])?></h5>
        <p class="card-text"><?=htmlspecialchars($p['description'])?></p>
        <p class="fw-bold">Rp <?=number_format($p['price'],0,',','.')?> / orang</p>
        <a href="booking.php?paket=<?=urlencode($p['id'])?>" class="btn btn-success">Pesan Sekarang</a>
      </div>
    </div>
  </div>
<?php endwhile; $res->free(); ?>
</div>

<?php include 'inc/footer.php'; ?>
