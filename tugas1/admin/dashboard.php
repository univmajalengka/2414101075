<?php
session_start();
if(!isset($_SESSION['admin_id'])) header('Location: login.php');
require_once '../inc/db.php';
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Admin - <?=htmlspecialchars($_SESSION['admin_name'])?></a>
    <div><a href="packages.php" class="btn btn-sm btn-warning">Manage Paket</a>
    <a href="bookings.php" class="btn btn-sm btn-info">Pemesanan</a>
    <a href="logout.php" class="btn btn-sm btn-danger">Logout</a></div>
  </div>
</nav>
<div class="container my-4">
  <h3>Ringkasan</h3>
  <?php
  $c1 = $mysqli->query("SELECT COUNT(*) as c FROM paket")->fetch_assoc()['c'];
  $c2 = $mysqli->query("SELECT COUNT(*) as c FROM booking")->fetch_assoc()['c'];
  ?>
  <div class="row">
    <div class="col-md-3"><div class="card p-3">Paket: <strong><?=$c1?></strong></div></div>
    <div class="col-md-3"><div class="card p-3">Booking: <strong><?=$c2?></strong></div></div>
  </div>
</div>
</body></html>
