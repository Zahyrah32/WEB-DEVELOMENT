<?php
session_start();
include 'db_connect.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$matric = $_GET['matric'];
$stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
$stmt->bind_param("s", $matric);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $role = $_POST['role'];
    
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name = ?, role = ?, password = ? WHERE matric = ?");
        $stmt->bind_param("ssss", $name, $role, $password, $matric);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, role = ? WHERE matric = ?");
        $stmt->bind_param("sss", $name, $role, $matric);
    }
    
    $stmt->execute();
    header("Location: display.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        
        <form method="post">
            <div class="form-group">
                <label>Matric:</label>
                <input type="text" value="<?php echo htmlspecialchars($user['matric']); ?>" disabled>
            </div>
            
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Role:</label>
                <select name="role" required>
                    <option value="student" <?php echo $user['role'] === 'student' ? 'selected' : ''; ?>>Student</option>
                    <option value="lecturer" <?php echo $user['role'] === 'lecturer' ? 'selected' : ''; ?>>Lecturer</option>
                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>New Password (leave blank to keep current):</label>
                <input type="password" name="password">
            </div>
            
            <button type="submit">Update</button>
            <a href="display.php">Cancel</a>
        </form>
    </div>
</body>
</html>