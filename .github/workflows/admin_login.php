<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #e2ffe9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
form {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    width: 300px;
    text-align: center;
    border: 2px solid #02693f;
}
input {
    width: 100%;
    padding: 8px;
    margin: 8px 0;
}
button {
    width: 100%;
    padding: 10px;
    background: #02693f;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background: #00b96e;
}
h2 {
    color: #02693f;
}
.error {
    color: red;
}
</style>
</head>
<body>

<form action="admin_auth.php" method="POST">
    <h2>Admin Login</h2>
    
    <?php if(isset($_GET['error'])): ?>
        <p class="error">Invalid Login!</p>
    <?php endif; ?>
    
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    
    <button type="submit">Login</button>
</form>
</body>
</html>
