<?php
session_start(); // Start session first

// Check if admin is logged in
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include "db.php";

// -------------------------
// HANDLE POST DELETION
// -------------------------
if(isset($_GET['delete'])){
    $delete_id = intval($_GET['delete']);

    // Delete media file if exists
    $mediaRow = $conn->query("SELECT media FROM posts WHERE id=$delete_id")->fetch_assoc();
    $mediaFile = "uploads/" . $mediaRow['media'];
    if(!empty($mediaRow['media']) && file_exists($mediaFile)){
        unlink($mediaFile);
    }

    // Delete post
    $conn->query("DELETE FROM posts WHERE id=$delete_id");

    header("Location: admin_dashboard.php");
    exit();
}

// -------------------------
// FETCH DATA
// -------------------------
$post_count = $conn->query("SELECT * FROM posts")->num_rows;
$messages = $conn->query("SELECT * FROM messages ORDER BY id DESC");
$posts = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<style>
body { font-family: Arial, sans-serif; background:#f2f2f2; padding:20px; }
h2 { color:#02693f; margin-bottom:10px; }
p { margin-bottom: 20px; }

/* TABLE STYLES */
table { width:100%; border-collapse:collapse; background:white; margin-bottom:30px; }
th, td { padding:12px; border:1px solid #ddd; text-align:left; }
th { background:#02693f; color:white; }

/* BUTTONS */
a.action-btn { padding:8px 14px; text-decoration:none; color:white; border-radius:6px; font-size:14px; }
.edit-btn { background:#1c8adb; }
.edit-btn:hover { background:#0b6fb5; }
.delete-btn { background:#dc3545; }
.delete-btn:hover { background:#b02a37; }

/* LOGOUT LINK */
.logout { float:right; background:#02693f; color:white; padding:5px 10px; text-decoration:none; border-radius:5px; }

/* MEDIA */
.media-preview { width:120px; border-radius:5px; margin-top:5px; }

/* FORM */
form { background:white; padding:20px; border-radius:10px; border:2px solid #02693f; margin-bottom:30px; }
input, select, textarea { width:100%; padding:8px; margin:8px 0; }
button { padding:10px 15px; background:#02693f; color:white; border:none; border-radius:5px; cursor:pointer; }
button:hover { background:#00b96e; }

.message { color:green; font-weight:bold; }
</style>
</head>

<body>

<a href="admin_logout.php" class="logout">Logout</a>
<li><a href="Home.php">HOME</a></li>
<h2>📊 Dashboard Overview</h2>
<p><strong>Total Posts:</strong> <?= $post_count ?></p>

<!-- USER MESSAGES -->
<h2>📩 User Messages</h2>
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Sent At</th>
</tr>
<?php while($row = $messages->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
    <td><?= $row['sent_at'] ?></td>
</tr>
<?php endwhile; ?>
</table>

<!-- ADD NEW POST BUTTON -->
<h2>📝 Posts Management</h2>
<p><a href="add_post.php" style="background:#02693f; color:#fff; padding:8px 12px; border-radius:5px; text-decoration:none;">Add New Post</a></p>

<table>
<tr>
    <th>ID</th>
    <th>Category</th>
    <th>Subcategory</th>
    <th>Title</th>
    <th>Media</th>
    <th>Content</th>
    <th>Date</th>
    <th>Actions</th>
</tr>
<?php while($row = $posts->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['category']) ?></td>
    <td><?= htmlspecialchars($row['subcategory_id']) ?></td>
    <td><?= htmlspecialchars($row['title']) ?></td>

    <!-- Media Preview -->
    <td>
        <?php if(!empty($row['media'])): 
            $ext = pathinfo($row['media'], PATHINFO_EXTENSION);
            if(in_array(strtolower($ext), ['mp4','mov','avi','webm'])): ?>
                <video width="150" controls>
                    <source src="uploads/<?= $row['media'] ?>" type="video/<?= $ext ?>">
                </video>
            <?php else: ?>
                <img src="uploads/<?= $row['media'] ?>" width="120" style="border-radius:5px;">
            <?php endif; ?>
        <?php else: ?>
            No Media
        <?php endif; ?>
    </td>

    <td><?= substr(nl2br(htmlspecialchars($row['content'])),0,150) ?>...</td>
    <td><?= $row['created_at'] ?></td>

    <td style="display:flex; gap:10px;">
        <a href="edit_post.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">Edit</a>
        <a href="admin_dashboard.php?delete=<?= $row['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
