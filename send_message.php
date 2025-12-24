<?php
include "db.php";

if(isset($_POST['message'])){

    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare(
        "INSERT INTO messages (name, email, message)
         VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();

    echo "Zikomo! Uthenga wanu watumizidwa bwino.";
}
?>
