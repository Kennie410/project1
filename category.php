<?php
include "db.php";

if(!isset($_GET['type'])){
    die("Category not selected.");
}

$category = $_GET['type'];
$subcategory = $_GET['sub'] ?? null;

// Prepare query based on whether a subcategory is selected
if($subcategory){
    $stmt = $conn->prepare("SELECT * FROM posts WHERE category = ? AND subcategory = ? ORDER BY created_at DESC");
    $stmt->bind_param("ss", $category, $subcategory);
} else {
    $stmt = $conn->prepare("SELECT * FROM posts WHERE category = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $category);
}

$stmt->execute();
$result = $stmt->get_result();

// Function to prettify titles
function formatTitle($text){
    return ucfirst(str_replace("_"," ",$text));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= formatTitle($category); ?></title>
<style>
body{font-family:Arial,sans-serif;background:#f4f4f4;padding:20px;}
h1{text-align:center;color:#02693f;}
.subcats{text-align:center;margin-bottom:20px;}
.subcats a{display:inline-block;margin:5px;padding:8px 12px;background:#02693f;color:#fff;border-radius:5px;text-decoration:none;font-size:14px;}
.subcats a:hover{background:#00ff6e;}
.post{background:#fff;padding:20px;margin:15px auto;border-radius:10px;border-left:5px solid #02693f;max-width:700px;}
.post img{width:100%;max-height:350px;object-fit:cover;border-radius:8px;margin-top:10px;}
.post h2{margin:0;color:#02693f;}
.post small{color:#555;}
.content{margin-top:10px;}
.more{display:none;}
.see-more{color:#02693f;cursor:pointer;font-weight:bold;}
a.back{display:inline-block;margin-bottom:20px;background:#02693f;color:#fff;padding:8px 12px;border-radius:5px;text-decoration:none;}
a.back:hover{background:#00ff6e;}
</style>
<script>
function toggleText(id){
    const more = document.getElementById("more"+id);
    const btn = document.getElementById("btn"+id);
    if(more.style.display==="none"){
        more.style.display="inline";
        btn.innerText="See less";
    }else{
        more.style.display="none";
        btn.innerText="See more";
    }
}
</script>
</head>
<body>

<a href="Home.php" class="back">← Back to Home</a>
<h1><?= formatTitle($category); ?></h1>

<?php if($category === "free_courses"): ?>
<div class="subcats">
    <a href="?type=free_courses&sub=ict">ICT</a>
    <a href="?type=free_courses&sub=food_production">Food Production</a>
    <a href="?type=free_courses&sub=carpentry_joinery">Carpentry & Joinery</a>
    <a href="?type=free_courses&sub=cosmetology">Cosmetology</a>
    <a href="?type=free_courses&sub=electrical">Electrical</a>
    <a href="?type=free_courses&sub=electronics">Electronics</a>
    <a href="?type=free_courses&sub=solar">Solar</a>
</div>
<?php endif; ?>

<?php if($result->num_rows > 0): $i=0; while($row = $result->fetch_assoc()): $i++; ?>
<div class="post">
    <h2><?= htmlspecialchars($row['title']); ?></h2>

    <?php if(!empty($row['media'])): ?>
        <?php 
        $ext = strtolower(pathinfo($row['media'], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg','jpeg','png','gif'])): ?>
            <img src="uploads/<?= htmlspecialchars($row['media']); ?>" alt="Post image">
        <?php elseif(in_array($ext, ['mp4','mov','avi'])): ?>
            <video width="100%" controls>
                <source src="uploads/<?= htmlspecialchars($row['media']); ?>" type="video/<?= $ext; ?>">
            </video>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $text = $row['content'];
    if(strlen($text) > 250){
        $short = substr($text, 0, 250);
        $rest = substr($text, 250);
    }else{
        $short = $text;
        $rest = "";
    }
    ?>
    <p class="content">
        <?= nl2br(htmlspecialchars($short)); ?>
        <?php if($rest): ?>
            <span id="more<?= $i; ?>" class="more"><?= nl2br(htmlspecialchars($rest)); ?></span>
            <span id="btn<?= $i; ?>" class="see-more" onclick="toggleText(<?= $i; ?>)"> See more</span>
        <?php endif; ?>
    </p>
    <small><i>Posted on <?= $row['created_at']; ?></i></small>
</div>
<?php endwhile; else: ?>
<p style="text-align:center;">No posts found.</p>
<?php endif; ?>

</body>
</html>
