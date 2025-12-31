<?php
session_start();

// Admin login details
$admin_user = "admin";
$admin_pass = "12345";

if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
    $_SESSION['admin'] = $admin_user;
    header("Location: admin.php");
    exit();
} else {
    header("Location: admin_login.php?error=1");
    exit();
}
?>
