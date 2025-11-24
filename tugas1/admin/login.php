<?php
session_start();
require_once '../inc/db.php';

$err = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $u = $_POST['username'];
  $p = $_POST['password'];
  $stmt = $mysqli->prepare("SELECT id,username,password,name FROM admin WHERE username=? LIMIT 1");
  $stmt->bind_param('s',$u);
  $stmt->execute();
  $res = $stmt->get_result();
  if($row = $res->fetch_assoc()){
    if(password_verify($p, $row['password'])){
      $_SESSION['admin_id'] = $row['id'];
      $_SESSION['admin_name'] = $row['name'];
      header('Location: dashboard.php');
      exit;
    } else $err = 'Password salah';
  } else $err = 'Username tidak ditemukan';
  $stmt->close();
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<div class="container" style="max-width:420px;margin-top:80px;">
  <div class="card p-4">
    <h4 class="mb-3">Admin Login</h4>
    <?php if($err): ?><div class="alert alert-danger"><?=$err?></div><?php endif; ?>
    <form method="post">
      <div class="mb-2"><input name="username" class="form-control" placeholder="Username" required></div>
      <div class="mb-3"><input name="password" type="password" class="form-control" placeholder="Password" required></div>
      <button class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</div>
</body></html>
