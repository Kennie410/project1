<?php
include "db.php";

if(!isset($_GET['type'])){
    die("Category not selected.");
}

$category = $_GET['type'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE category = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

function formatTitle($cat){
    return ucfirst(str_replace("_", " ", $cat));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= formatTitle($category); ?></title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    padding: 20px;
}
h1 {
    text-align: center;
    color: #02693f;
}
.post {
    background: white;
    padding: 20px;
    margin: 15px auto;
    border-radius: 10px;
    border-left: 5px solid #02693f;
    max-width: 700px;
}
.post h2 {
    margin: 0;
    color: #02693f;
}
.post p {
    margin-top: 10px;
}
a.back {
    display: inline-block;
    margin-bottom: 20px;
    background: #02693f;
    color: #fff;
    padding: 8px 12px;
    border-radius: 5px;
    text-decoration: none;
}
</style>
</head>
<body>

<a href="Home.php" class="back">← Back to Home</a>

<h1><?= formatTitle($category); ?></h1>

<?php if($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="post">
            <h2><?= $row['title']; ?></h2>
            <p><?= $row['content']; ?></p>
            <small><i>Posted on <?= $row['created_at']; ?></i></small>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p style="text-align:center;">No posts found in this category.</p>
<?php endif; ?>

</body>
</html>
