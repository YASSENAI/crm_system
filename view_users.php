<?php
session_start();
include "config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>عرض المستخدمين</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>👥 قائمة المستخدمين</header>
  <div class="container">
    <table>
      <tr>
        <th>الرقم</th>
        <th>اسم المستخدم</th>
        <th>الدور</th>
        <th>إجراءات</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td>
          <a class="btn" href="edit_user.php?id=<?php echo $row['id']; ?>">✏ تعديل</a>
          <a class="btn" style="background:#e74c3c;" href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('هل تريد حذف هذا المستخدم؟')">🗑 حذف</a>
        </td>
      </tr>
      <?php } ?>
    </table>
   <a href="<?php echo ($_SESSION['role'] == 'admin') ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>" class="btn back">⬅ رجوع</a>
  </div>
</body>
</html>
