<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $age = (int)$_POST['age'];

    $sql = "UPDATE users SET name='$name', email='$email', age=$age WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: index.php?status=updated");
    } else {
        header("Location: index.php?status=error");
    }
    exit();
}
?>