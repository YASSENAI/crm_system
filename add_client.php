<?php
session_start();
include "config.php";

if (!isset($_SESSION['username']) || !in_array($_SESSION['role'], ['admin','user'])) {
    header("Location: index.php");
    exit;
}

# جلب المنتجات من قاعدة البيانات
$products = $conn->query("SELECT * FROM products");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $product_id = $_POST['product'];

    $sql = "INSERT INTO clients (name, phone, email) VALUES ('$name','$phone','$email')";
    if ($conn->query($sql)) {
        $client_id = $conn->insert_id;
        
        if ($product_id) {
            $conn->query("INSERT INTO client_products (client_id, product_id) VALUES ('$client_id','$product_id')");
        }

        $msg = "✅ تم إضافة العميل مع المنتج بنجاح";
    } else {
        $msg = "❌ خطأ: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إضافة عميل</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>➕ إضافة عميل جديد</header>
  <div class="container">
    <form method="POST">
      <input type="text" name="name" placeholder="اسم العميل" required>
      <input type="text" name="phone" placeholder="رقم الهاتف" required>
      <input type="email" name="email" placeholder="البريد الإلكتروني">
      
      <select name="product" required>
        <option value="">-- اختر المنتج --</option>
        <?php while($row = $products->fetch_assoc()) { ?>
          <option value="<?php echo $row['id']; ?>">
            <?php echo $row['name']." - ".$row['price']." جنيه"; ?>
          </option>
        <?php } ?>
      </select>

      <button type="submit">💾 حفظ</button>
    </form>
    <?php if (isset($msg)) echo "<p style='margin-top:15px;'>$msg</p>"; ?>
    <a href="<?php echo ($_SESSION['role'] == 'admin') ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>" class="btn back">⬅ رجوع</a>

  </div>
</body>
</html>
