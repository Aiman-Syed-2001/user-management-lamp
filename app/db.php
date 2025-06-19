<?php
$servername = "db";
$username = "lampuser";
$password = "password123";
$database = "userdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



