<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle delete action
if (isset($_GET['delete'])) {
    $matric = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    header("Location: display.php");
    exit();
}

// Get all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .action-btn { padding: 5px 10px; text-decoration: none; }
        .edit-btn { background: #4CAF50; color: white; }
        .delete-btn { background: #f44336; color: white; }
        .add-btn { display: inline-block; margin-bottom: 20px; padding: 10px; background: #2196F3; color: white; text-decoration: none; }
    </style>
</head>
<body>
    <h1>User Management</h1>
    
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="add_user.php" class="add-btn">Add New User</a>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Level</th>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['matric']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['role']); ?></td>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <td>
                        <a href="edit_user.php?matric=<?php echo $row['matric']; ?>" class="action-btn edit-btn">Update</a>
                        <a href="display.php?delete=<?php echo $row['matric']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <p><a href="logout.php">Logout</a></p>
</body>
</html>