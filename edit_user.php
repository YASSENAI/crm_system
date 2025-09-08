<?php
session_start();
include "config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: view_users.php");
    exit;
}

$user_id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM users WHERE id=$user_id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];

    $update_query = "UPDATE users SET username='$username', role='$role'";

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $update_query .= ", password='$password'";
    }

    $update_query .= " WHERE id=$user_id";

    if ($conn->query($update_query)) {
        $msg = "✅ تم تعديل بيانات المستخدم بنجاح";
    } else {
        $msg = "❌ خطأ: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تعديل مستخدم</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>✏ تعديل المستخدم</header>
  <div class="container">
    <form method="POST">
      <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
      <input type="password" name="password" placeholder="كلمة مرور جديدة (اختياري)">
      <select name="role">
        <option value="user" <?php if($user['role']=="user") echo "selected"; ?>>مستخدم</option>
        <option value="admin" <?php if($user['role']=="admin") echo "selected"; ?>>أدمن</option>
      </select>
      <button type="submit">💾 حفظ التعديلات</button>
    </form>
    <?php if (isset($msg)) echo "<p style='margin-top:15px;'>$msg</p>"; ?>
    <a href="view_users.php" class="btn">⬅ رجوع</a>
  </div>
</body>
</html>
