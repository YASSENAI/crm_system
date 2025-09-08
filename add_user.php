<?php

session_start();
include "config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username','$password','$role')";
    if ($conn->query($sql)) {
        $msg = "✅ تمت إضافة المستخدم بنجاح";
    } else {
        $msg = "❌ خطأ: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إضافة مستخدم</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>➕ إضافة مستخدم جديد</header>
  <div class="container">
    <form method="POST">
      <input type="text" name="username" placeholder="اسم المستخدم" required>
      <input type="password" name="password" placeholder="كلمة المرور" required>
      <select name="role" required>
        <option value="user">مستخدم</option>
        <option value="admin">أدمن</option>
      </select>
      <button type="submit">💾 حفظ</button>
    </form>
    <?php if (isset($msg)) echo "<p style='margin-top:15px;'>$msg</p>"; ?>
    <a href="admin_dashboard.php" class="btn">⬅ رجوع</a>
  </div>
</body>
</html>
