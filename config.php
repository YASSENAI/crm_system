<?php
$host = "localhost";
$user = "root"; // غيره حسب جهازك
$pass = "";
$db   = "crm_system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
?>
