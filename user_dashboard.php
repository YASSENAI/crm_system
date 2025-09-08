<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>لوحة تحكم المستخدم</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>لوحة تحكم المستخدم</header>
  <div class="container">
    <h1>مرحباً يا <?php echo $_SESSION['username']; ?> 🙋</h1>
<div class="dashboard">
  <a href="add_client.php">➕ إضافة عميل</a>
  <a href="view_clients.php">👥 عرض العملاء</a>
  <a href="logout.php">🚪 تسجيل الخروج</a>
</div>
  </div>
</body>
</html>
