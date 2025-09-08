<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT c.*, p.name AS product_name, p.price 
        FROM clients c
        LEFT JOIN client_products cp ON c.id = cp.client_id
        LEFT JOIN products p ON cp.product_id = p.id
        ORDER BY c.id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>عرض العملاء</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>📋 قائمة العملاء</header>
  <div class="container">
    <table>
        ...<tr>
  <th>الرقم</th>
  <th>الاسم</th>
  <th>الهاتف</th>
  <th>الإيميل</th>
  <th>المنتج</th>
  <th>السعر</th>
  <th>تاريخ التسجيل</th>
  <?php if ($_SESSION['role'] == 'admin') { ?>
    <th>إجراءات</th>
  <?php } ?>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
  <td><?php echo $row['id']; ?></td>
  <td><?php echo $row['name']; ?></td>
  <td><?php echo $row['phone']; ?></td>
  <td><?php echo $row['email']; ?></td>
  <td><?php echo $row['product_name'] ?? "—"; ?></td>
  <td><?php echo $row['price'] ? $row['price']." جنيه" : "—"; ?></td>
  <td><?php echo $row['created_at']; ?></td>
  <?php if ($_SESSION['role'] == 'admin') { ?>
    <td>
      <a class="btn" href="edit_client.php?id=<?php echo $row['id']; ?>">✏ تعديل</a>
      <a class="btn" style="background:#e74c3c;" 
         href="delete_client.php?id=<?php echo $row['id']; ?>" 
         onclick="return confirm('هل تريد حذف هذا العميل؟')">🗑 حذف</a>
    </td>
  <?php } ?>
</tr>
<?php } ?>

<table>

    </table>
    <a href="<?php echo ($_SESSION['role']=='admin')?'admin_dashboard.php':'user_dashboard.php'; ?>" class="btn">⬅ رجوع</a>
  </div>
</body>
</html>





