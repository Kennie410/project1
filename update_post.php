<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include "db.php";

$id = intval($_POST['id']);
$title = $_POST['title'];
$category = $_POST['category'];
$content = $_POST['content'];
$old_media = $_POST['old_media'];

$new_media = $old_media;

// If admin uploads a new file
if (!empty($_FILES['media']['name'])) {
    $file_name = time() . "_" . $_FILES['media']['name'];
    $target = "uploads/" . $file_name;

    if (move_uploaded_file($_FILES['media']['tmp_name'], $target)) {

        // delete old file if exists
        if ($old_media != "" && file_exists("uploads/" . $old_media)) {
            unlink("uploads/" . $old_media);
        }

        $new_media = $file_name;
    }
}

$stmt = $conn->prepare("
    UPDATE posts 
    SET category = ?, title = ?, content = ?, media = ?
    WHERE id = ?
");

$stmt->bind_param("ssssi", $category, $title, $content, $new_media, $id);
$stmt->execute();

header("Location: admin_dashboard.php?updated=1");
exit();
