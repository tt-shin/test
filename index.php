<?php
// Database configuration
$host = "";
$username = "admin";
$password = "awsprojectdb";
$dbname = "project";

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'add') {
        $name = $_POST['user_name'];
        $email = $_POST['user_email'];
        $conn->query("INSERT INTO users (user_name, user_email) VALUES ('$name', '$email')");
    } elseif ($action == 'edit') {
        $id = $_POST['user_id'];
        $name = $_POST['user_name'];
        $email = $_POST['user_email'];
        $conn->query("UPDATE users SET user_name='$name', user_email='$email' WHERE user_id=$id");
    } elseif ($action == 'delete') {
        $id = $_POST['user_id'];
        $conn->query("DELETE FROM users WHERE user_id=$id");
    }
}

// Fetch all users
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP CRUD Application</title>
</head>
<body>
    <h1>PHP CRUD Application</h1>

    <!-- Add User Form -->
    <h2>Add User</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <label>Name:</label>
        <input type="text" name="user_name" required>
        <label>Email:</label>
        <input type="email" name="user_email" required>
        <button type="submit">Add</button>
    </form>

    <!-- User List -->
    <h2>User List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['user_name'] ?></td>
                    <td><?= $row['user_email'] ?></td>
                    <td>
                        <!-- Edit Form -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                            <input type="text" name="user_name" value="<?= $row['user_name'] ?>" required>
                            <input type="email" name="user_email" value="<?= $row['user_email'] ?>" required>
                            <button type="submit">Update</button>
                        </form>

                        <!-- Delete Form -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
