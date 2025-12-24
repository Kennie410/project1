<?php
session_start();
include "db.php";

// Check if form submitted
if(isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch admin from database
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Verify password
        if(password_verify($password, $admin['password'])){
            // Correct login
            $_SESSION['admin'] = $admin['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Wrong password
            header("Location: admin_login.php?error=1");
            exit();
        }

    } else {
        // Admin username not found
        header("Location: admin_login.php?error=1");
        exit();
    }

} else {
    // Form not submitted
    header("Location: admin_login.php");
    exit();
}
?>
