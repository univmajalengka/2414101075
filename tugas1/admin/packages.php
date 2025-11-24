<?php
session_start();
if(!isset($_SESSION['admin_id'])) header('Location: login.php');
require_once '../inc/db.php';

$action = $_GET['action'] ?? 'list';

if($action == 'add' && $_SERVER['REQUEST_METHOD']=='POST'){
  $title = $_POST['title']; $desc = $_POST['description']; $price = intval($_POST['price']);
  $imgPath = null;
  if(isset($_FILES['image']) && $_FILES['image']['error']===0){
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fn = 'assets/images/pak_'.time().'.'.$ext;
    if(move_uploaded_file($_FILES['image']['tmp_name'], '../'.$fn)){
      $imgPath = $fn;
    }
  }
  $stmt = $mysqli->prepare("INSERT INTO paket (title,description,price,image) VALUES(?,?,?,?)");
  $stmt->bind_param('ssis', $title, $desc, $price, $imgPath);
  $stmt->execute();
  header('Location: packages.php');
  exit;
}

if($action == 'delete' && isset($_GET['id'])){
  $id = intval($_GET['id']);
  $r = $mysqli->query("SELECT image FROM paket WHERE id=$id")->fetch_assoc();
  if($r && $r['image'] && file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
  $mysqli->query("DELETE FROM paket WHERE id=$id");
  header('Location: packages.php');
  exit;
}

if($action == 'edit' && isset($_GET['id'])){
  $id = intval($_GET['id']);
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $title = $_POST['title']; $desc = $_POST['description']; $price = intval($_POST['price']);
    $imgPath = null;
    if(isset($_FILES['image']) && $_FILES['image']['error']===0){
      $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      $fn = 'assets/images/pak_'.time().'.'.$ext;
      if(move_uploaded_file($_FILES['image']['tmp_name'], '../'.$fn)){
        $imgPath = $fn;
      }
    }
    if($imgPath){
      $stmt = $mysqli->prepare("UPDATE paket SET title=?,description=?,price=?,image=? WHERE id=?");
      $stmt->bind_param('ssisi',$title,$desc,$price,$imgPath,$id);
    } else {
      $stmt = $mysqli->prepare("UPDATE paket SET title=?,description=?,price=? WHERE id=?");
      $stmt->bind_param('ssii',$title,$desc,$price,$id);
    }
    $stmt->execute();
    header('Location: packages.php');
    exit;
  } else {
    $pak = $mysqli->query("SELECT * FROM paket WHERE id=$id")->fetch_assoc();
  }
}

$rows = $mysqli->query("SELECT * FROM paket ORDER BY created_at DESC");
?>
<!doctype html><html><head><meta charset="utf-8"><title>Manage Paket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<nav class="navbar navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="dashboard.php">Admin</a>
<a href="logout.php" class="btn btn-sm btn-danger">Logout</a></div></nav>
<div class="container my-4">
  <h3>Manage Paket</h3>
  <a href="packages.php?action=add" class="btn btn-success mb-3">Tambah Paket</a>

<?php if($action=='add'): ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-2"><input name="title" class="form-control" placeholder="Judul" required></div>
    <div class="mb-2"><textarea name="description" class="form-control" placeholder="Deskripsi"></textarea></div>
    <div class="mb-2"><input name="price" class="form-control" placeholder="Harga (angka)"></div>
    <div class="mb-2"><input type="file" name="image" class="form-control"></div>
    <button class="btn btn-primary">Simpan</button>
  </form>
<?php elseif($action=='edit'): ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-2"><input name="title" value="<?=htmlspecialchars($pak['title'])?>" class="form-control" required></div>
    <div class="mb-2"><textarea name="description" class="form-control"><?=htmlspecialchars($pak['description'])?></textarea></div>
    <div class="mb-2"><input name="price" value="<?=htmlspecialchars($pak['price'])?>" class="form-control"></div>
    <div class="mb-2"><input type="file" name="image" class="form-control"></div>
    <button class="btn btn-primary">Update</button>
  </form>
<?php else: ?>
  <table class="table">
    <thead><tr><th>Gambar</th><th>Judul</th><th>Harga</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php while($r=$rows->fetch_assoc()): ?>
      <tr>
        <td style="width:160px"><?php if($r['image']): ?><img src="../<?=htmlspecialchars($r['image'])?>" style="height:60px;object-fit:cover"><?php endif;?></td>
        <td><?=htmlspecialchars($r['title'])?></td>
        <td>Rp <?=number_format($r['price'],0,',','.')?></td>
        <td>
          <a href="packages.php?action=edit&id=<?=$r['id']?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="packages.php?action=delete&id=<?=$r['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
<?php endif; ?>

</div>
</body></html>
