<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

include "config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $conn->query("DELETE FROM users WHERE id=$user_id");
}

header("Location: view_users.php");
exit;
?>
