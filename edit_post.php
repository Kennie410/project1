<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include "db.php";
$message = "";

/* =========================
   GET POST ID
========================= */
if (!isset($_GET['id'])) {
    die("Post ID missing");
}
$post_id = intval($_GET['id']);

/* =========================
   FETCH POST
========================= */
$stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    die("Post not found");
}

/* =========================
   SAME CATEGORIES AS ADD POST
========================= */
$categories = ['Free Courses', 'Awards', 'Events', 'Programs'];

$free_courses_sub = [
    'ICT',
    'Food Production',
    'Carpentry & Joinery',
    'Cosmetology',
    'Electrical',
    'Electronics',
    'Solar'
];

/* =========================
   UPDATE POST
========================= */
if (isset($_POST['update'])) {

    $category = $_POST['category'];
    $subcategory = ($category === 'Free Courses' && isset($_POST['subcategory']))
        ? $_POST['subcategory']
        : '';

    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare(
        "UPDATE posts 
         SET category=?, subcategory_id=?, title=?, content=? 
         WHERE id=?"
    );
    $stmt->bind_param(
        "ssssi",
        $category,
        $subcategory,
        $title,
        $content,
        $post_id
    );

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?updated=1");
        exit();
    } else {
        $message = "Failed to update post.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Post</title>
<style>
body { font-family:sans-serif; background:#f4f4f4; display:flex; flex-direction:column; align-items:center; padding:20px; }
h1 { color:#02693f; margin-bottom:20px; }
a.back { text-decoration:none; color:#fff; background:#02693f; padding:8px 12px; border-radius:6px; margin-bottom:20px; display:inline-block; }
form { background:#fff; padding:25px; border-radius:12px; border:2px solid #02693f; width:100%; max-width:500px; display:flex; flex-direction:column; gap:15px; }
input, select, textarea, button { font-size:16px; padding:10px; border-radius:10px; border:2px solid #02693f; width:100%; }
button { background:#02693f; color:#fff; font-weight:bold; cursor:pointer; border:none; }
button:hover { background:#00b056; }
.error { color:red; font-weight:bold; text-align:center; }
</style>
</head>
<body>

<h1>Edit Post</h1>
<a href="admin_dashboard.php" class="back">← Back to Dashboard</a>

<?php if($message): ?>
<p class="error"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label>Category:</label>
    <select name="category" onchange="this.form.submit()" required>
        <option value="">Select Category</option>
        <?php foreach($categories as $cat): ?>
            <option value="<?= $cat ?>"
                <?= ($post['category'] == $cat) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php
    $currentCategory = $_POST['category'] ?? $post['category'];
    ?>

    <?php if($currentCategory === 'Free Courses'): ?>
        <label>Subcategory:</label>
        <select name="subcategory" required>
            <option value="">Select Subcategory</option>
            <?php foreach($free_courses_sub as $sub): ?>
                <option value="<?= $sub ?>"
                    <?= ($post['subcategory_id'] == $sub) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sub) ?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>

    <label>Title:</label>
    <input type="text" name="title"
           value="<?= htmlspecialchars($post['title']) ?>" required>

    <label>Content:</label>
    <textarea name="content" rows="5" required><?= htmlspecialchars($post['content']) ?></textarea>

    <button type="submit" name="update">Update Post</button>
</form>

</body>
</html>
