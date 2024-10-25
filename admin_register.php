<?php
include 'db.php'; // Ensure this is included to connect to the database
session_start(); // Start session management

// Handle admin registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_username = trim($_POST['admin_username']);
    $admin_password = trim($_POST['admin_password']);
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT); // Hash the password for security

    // Prepare SQL statement to insert new admin
    $sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ss", $admin_username, $hashed_password);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Admin registered successfully! You can now <a href='admin_login.php'>log in</a>.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>"; // Show error if insertion fails
        }

        $stmt->close(); // Close the statement
    } else {
        echo "<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>"; // Show error if preparation fails
    }
    
    $conn->close(); // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Admin Registration</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Register Admin</h2>
        <form action="admin_register.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="admin_username">Username:</label>
                <input type="text" class="form-control" name="admin_username" id="admin_username" required>
            </div>
            <div class="form-group">
                <label for="admin_password">Password:</label>
                <input type="password" class="form-control" name="admin_password" id="admin_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="mt-3">
            <a href="admin_login.php" class="btn btn-secondary">Back to Admin Login</a> <!-- Link to admin login -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
