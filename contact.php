<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact - Youth With Vision Malawi</title>
<link rel="stylesheet" href="contact.css">
</head>
<body>

<header class="nav">
    <img src="images/logo.jpg" class="logo" alt="Logo">
    <ul class="menu">
        <li><a href="Home.php">HOME</a></li>
        <li><a href="contact.php">CONTACT US</a></li>
        <li><a href="about.php">ABOUT</a></li>
    </ul>
</header>

<main class="container">
    <h1>Youth With Vision Malawi</h1>
    <p class="subtext">Creating Responsible Youth Around The Nation</p>

    <form action="save_message.php" method="POST" class="contact-form">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</main>

<footer>
    © 2025 Youth With Vision Malawi — All Rights Reserved
</footer>
</body>
</html>
