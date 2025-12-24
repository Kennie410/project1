<?php
include "db.php";

$username = "admin";
$password = "admin123";

// Hash the password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed);
$stmt->execute();

echo "Admin account created!";
?>
