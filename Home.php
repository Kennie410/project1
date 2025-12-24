<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youth With Vision Malawi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigation Bar -->
<div class="nav">
    <img src="images/logo.jpg" class="logo" alt="Logo">
    <ul class="menu">
        <li><a href="Home.php">HOME</a></li>
        <li><a href="contact.php">CONTACT US</a></li>
        <li><a href="about.php">ABOUT</a></li>
        <?php if(isset($_SESSION['admin'])): ?>
        <?php endif; ?>
    </ul>
</div>

<!-- Main Container -->
<div class="container">
    <h1>Youth With Vision Malawi</h1>
    <p class="subtext">Creating Responsible Youth Around The Nation</p>

    <!-- Cards Section -->
    <div class="cards">
        <a href="category.php?type=free_courses">
            <div class="card blue"><p class="tip">Free<br>Courses</p></div>
        </a>
        <a href="category.php?type=awards">
            <div class="card green"><p class="tip">Awards</p></div>
        </a>
        <a href="category.php?type=events">
            <div class="card yellow"><p class="tip">Other<br>Events</p></div>
        </a>
        <a href="category.php?type=programs">
            <div class="card blue"><p class="tip">Programs</p></div>
        </a>
    </div>

    <!-- Admin Access Button -->
    <?php if(isset($_SESSION['admin'])): ?>
        <div style="text-align:center; margin:30px 0;">
            <a href="admin_dashboard.php" 
               style="padding:12px 25px; background:#02693f; color:white; text-decoration:none; border-radius:8px; font-weight:bold; font-size:16px;">
               Admin Dashboard
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer>
    © 2025 Youth With Vision Malawi — All Rights Reserved
</footer>

</body>
</html>
