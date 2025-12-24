<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include "db.php";
$message = "";

// Categories (text)
$categories = ['Free Courses', 'Awards', 'Events', 'Programs'];

// Subcategories for Free Courses
$free_courses_sub = ['ICT', 'Food Production', 'Carpentry & Joinery', 'Cosmetology', 'Electrical', 'Electronics', 'Solar'];

if(isset($_POST['submit_post'])){
    $category = $_POST['category'];
    $subcategory = ($category === 'Free Courses' && isset($_POST['subcategory'])) ? $_POST['subcategory'] : '';
    $title = $_POST['title'];
    $content = $_POST['content'];
    $media_name = "";

    // Handle media
    if(!empty($_FILES['media']['name'])){
        $target_dir = "uploads/";
        $media_name = time() . "_" . basename($_FILES["media"]["name"]);
        $target_file = $target_dir . $media_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','mp4','mov','avi'];

        if(in_array($file_type, $allowed)){
            if(!move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)){
                $message = "Failed to upload media.";
            }
        } else $message = "Invalid file type.";
    }

    if($message == ""){
        $stmt = $conn->prepare("INSERT INTO posts (category, subcategory_id, title, content, media) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $category, $subcategory_id, $title, $content, $media_name);
        if($stmt->execute()){
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $message = "Failed to save post.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add New Post</title>
<style>
/* Your previous CSS styling here */
body { font-family:sans-serif; background:#f4f4f4; display:flex; flex-direction:column; align-items:center; padding:20px; }
h1 { color:#02693f; margin-bottom:20px; }
a.back { text-decoration:none; color:#fff; background:#02693f; padding:8px 12px; border-radius:6px; margin-bottom:20px; display:inline-block; }
a.back:hover { background:#00b056; }
form { background:#fff; padding:25px; border-radius:12px; border:2px solid #02693f; width:100%; max-width:500px; display:flex; flex-direction:column; gap:15px; }
input, select, textarea, button { font-size:16px; padding:10px; border-radius:10px; border:2px solid #02693f; outline:none; width:100%; box-sizing:border-box; transition:0.3s ease; }
input:focus, select:focus, textarea:focus { border-color:#00ff6e; box-shadow:0 0 8px rgba(0,255,110,0.5); }
button { background:#02693f; color:#fff; font-weight:bold; cursor:pointer; border:none; transition:0.3s ease; }
button:hover { background:#00b056; transform:scale(1.05); }
button:active { transform:scale(0.95); filter:brightness(85%); }
.error { color:red; font-weight:bold; text-align:center; }
</style>
</head>
<body>

<h1>Add New Post</h1>
<a href="admin_dashboard.php" class="back">← Back to Dashboard</a>

<?php if($message): ?>
<p class="error"><?= $message ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Category:</label>
    <select name="category" onchange="this.form.submit()" required>
        <option value="">Select Category</option>
        <?php foreach($categories as $cat): ?>
            <option value="<?= $cat ?>" <?php if(isset($_POST['category']) && $_POST['category']==$cat) echo "selected" ?>>
                <?= htmlspecialchars($cat) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if(isset($_POST['category']) && $_POST['category']=='Free Courses'): ?>
        <label>Subcategory:</label>
        <select name="subcategory" required>
            <option value="">Select Subcategory</option>
            <?php foreach($free_courses_sub as $sub): ?>
                <option value="<?= $sub ?>" <?php if(isset($_POST['subcategory']) && $_POST['subcategory']==$sub) echo "selected" ?>>
                    <?= htmlspecialchars($sub) ?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>

    <label>Title:</label>
    <input type="text" name="title" value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>" required>

    <label>Content:</label>
    <textarea name="content" rows="5" required><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>

    <label>Media (optional):</label>
    <input type="file" name="media">

    <button type="submit" name="submit_post">Add Post</button>
</form>

</body>
</html>
