<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include "db.php";

if (!isset($_GET['id'])) {
    die("Post ID missing.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Post not found.");
}

$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>

    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #f2f2f2;
        }

        .container {
            width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover { background: #218838; }

        .media-preview {
            width: 140px;
            margin-top: 10px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
<div class="container">
    <h2>Edit Post</h2>

    <form action="update_post.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $post['id']; ?>">
        <input type="hidden" name="old_media" value="<?= $post['media']; ?>">

        <label>Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']); ?>" required>

        <label>Category:</label>
        <select name="category" required>
            <option value="<?= $post['category']; ?>"><?= ucfirst(str_replace("_"," ",$post['category'])); ?></option>
            <option value="news">News</option>
            <option value="events">Events</option>
            <option value="announcements">Announcements</option>
        </select>

        <label>Current Media:</label><br>
        <?php if ($post['media'] != ""): ?>
            <?php if (strstr($post['media'], '.mp4')): ?>
                <video src="uploads/<?= $post['media']; ?>" width="150" controls></video>
            <?php else: ?>
                <img src="uploads/<?= $post['media']; ?>" class="media-preview">
            <?php endif; ?>
        <?php else: ?>
            <p>No Media</p>
        <?php endif; ?>

        <label>Replace Media (optional):</label>
        <input type="file" name="media">

        <label>Content:</label>
        <textarea name="content" rows="5"><?= htmlspecialchars($post['content']); ?></textarea>

        <button type="submit">Update Post</button>

    </form>

</div>
</body>
</html>
