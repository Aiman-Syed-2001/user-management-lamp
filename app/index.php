<?php
include 'session.php';
include 'db.php';
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User CRUD App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        form input[type="text"],
        form input[type="email"],
        form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .nav {
            text-align: right;
            margin-bottom: 20px;
        }

        .nav a {
            margin-left: 10px;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .welcome {
            float: left;
            font-weight: bold;
            color: #555;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <span class="welcome">Welcome, <?= $_SESSION['user'] ?? 'Guest' ?></span>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </div>
        <h2>Add User</h2>
        <form action="add.php" method="post">
            <input type="text" name="name" placeholder="Enter name" required>
            <input type="email" name="email" placeholder="Enter email" required>
            <input type="number" name="age" placeholder="Enter age" required>
            <input type="submit" value="Add User">
        </form>

        <h2>All Users</h2>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Age</th><th>Actions</th></tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= $row['age'] ?></td>
                <td class="actions">
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('>                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>