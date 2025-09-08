<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>لوحة تحكم الأدمن</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>لوحة تحكم الأدمن</header>
  <div class="dashboard">
  <a href="add_client.php">➕ إضافة عميل</a>
  <a href="view_clients.php">👥 عرض العملاء</a>
  <a href="add_user.php">➕ إضافة مستخدم</a>
  <a href="view_users.php">👥 عرض المستخدمين</a>
  <a href="logout.php">🚪 تسجيل الخروج</a>
  <a href="<?php echo ($_SESSION['role'] == 'admin') ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>" class="btn back">⬅ رجوع</a>

</div>
</div>
</body>
</html>
