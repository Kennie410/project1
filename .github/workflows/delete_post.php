if(isset($_GET['delete'])){
    $delete_id = intval($_GET['delete']);

    // Get media file
    $mediaRow = $conn->query("SELECT media FROM posts WHERE id=$delete_id")->fetch_assoc();
    $mediaFile = "uploads/" . $mediaRow['media'];

    // Delete file ONLY if it exists
    if (!empty($mediaRow['media']) && file_exists($mediaFile)) {
        unlink($mediaFile);
    }

    // Delete post from database
    $conn->query("DELETE FROM posts WHERE id=$delete_id");

    header("Location: admin_dashboard.php");
    exit();
}
