<?php
session_start();
include "config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: view_clients.php");
    exit;
}

$client_id = intval($_GET['id']);

# جلب بيانات العميل
$sql = "SELECT c.*, cp.product_id 
        FROM clients c 
        LEFT JOIN client_products cp ON c.id = cp.client_id 
        WHERE c.id=$client_id";
$result = $conn->query($sql);
$client = $result->fetch_assoc();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

# جلب قائمة المنتجات
$products = $conn->query("SELECT * FROM products");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $product_id = $_POST['product'];

    # تحديث بيانات العميل
    $conn->query("UPDATE clients SET name='$name', phone='$phone', email='$email' WHERE id=$client_id");

    # تحديث المنتج
    $conn->query("DELETE FROM client_products WHERE client_id=$client_id");
    if ($product_id) {
        $conn->query("INSERT INTO client_products (client_id, product_id) VALUES ($client_id, $product_id)");
    }

    $msg = "✅ تم تحديث بيانات العميل بنجاح";
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تعديل عميل</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>✏ تعديل بيانات العميل</header>
  <div class="container">
    <form method="POST">
      <input type="text" name="name" value="<?php echo $client['name']; ?>" required>
      <input type="text" name="phone" value="<?php echo $client['phone']; ?>" required>
      <input type="email" name="email" value="<?php echo $client['email']; ?>">

      <select name="product">
        <option value="">-- اختر المنتج --</option>
        <?php while($row = $products->fetch_assoc()) { ?>
          <option value="<?php echo $row['id']; ?>" 
            <?php if ($client['product_id'] == $row['id']) echo "selected"; ?>>
            <?php echo $row['name']." - ".$row['price']." جنيه"; ?>
          </option>
        <?php } ?>
      </select>

      <button type="submit">💾 حفظ التعديلات</button>
    </form>
    <?php if (isset($msg)) echo "<p style='margin-top:15px;'>$msg</p>"; ?>
    <a href="view_clients.php" class="btn">⬅ رجوع</a>
  </div>
</body>
</html>
