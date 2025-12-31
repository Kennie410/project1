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

<!-- NAVIGATION -->
<div class="nav">
    <img src="images/logo.jpg" class="logo">
    
    <ul class="menu">
        <li><a href="Home.php">HOME</a></li>
        <li><a href="programs.php">PROGRAMS</a></li>
        <li><a href="contact.html">ABOUT US</a></li>
        <li><a href="about.html">CONTACTS</a></li>
    </ul>
</div>

<!-- MAIN CONTENT WHITE BOX -->
<div class="container">
    <h1>Youth With Vision Malawi</h1>
    <p class="subtext">Creating Responsible Youth Around The Nation</p>

    <!-- ⭐ CATEGORY CARDS (CLICKABLE) ⭐ -->
    <div class="cards">

        <a href="category.php?type=free_courses" style="text-decoration:none;">
            <div class="card blue">
                <p class="tip">Free<br>Courses</p>
            </div>
        </a>

        <a href="category.php?type=awards" style="text-decoration:none;">
            <div class="card green">
                <p class="tip">Awards</p>
            </div>
        </a>

        <a href="category.php?type=events" style="text-decoration:none;">
            <div class="card yellow">
                <p class="tip">Other<br>Events</p>
            </div>
        </a>

        <a href="category.php?type=programs" style="text-decoration:none;">
            <div class="card blue">
                <p class="tip">Programs</p>
            </div>
        </a>

    </div>
</div>

<!-- FOOTER -->
<footer>
    © 2025 Youth With Vision Malawi — All Rights Reserved
</footer>

</body>
</html>
