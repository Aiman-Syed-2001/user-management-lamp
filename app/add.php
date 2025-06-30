<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: form.php");
    exit();
}

include 'db.php';

$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$age = (int)$_POST['age'];

$sql = "INSERT INTO users (name, email, age) VALUES ('$name', '$email', $age)";
$conn->query($sql);

header("Location: index.php");
exit();
?>