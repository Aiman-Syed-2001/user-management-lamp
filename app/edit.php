<?php
include 'db.php';

$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id = $id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 40px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

         form input[type="text"],
        form input[type="email"],
        form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        form input[type="submit"]:hover {
            background-color: #218838;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
            text-align: center;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit User</h2>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required placeholder="Enter name">
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required placeholder="Enter email">
            <input type="number" name="age" value="<?= $user['age'] ?>" required placeholder="Enter age">
            <input type="submit" value="Update User">
        </form>
        <a href="index.php">← Back to Users</a>
    </div>
</body>
</html>