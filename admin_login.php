<?php
include 'db.php'; // Ensure this is included to connect to the database
session_start(); // Start session management

// Handle admin login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_username = trim($_POST['admin_username']);
    $admin_password = trim($_POST['admin_password']);

    // Validate input
    if (empty($admin_username) || empty($admin_password)) {
        echo "<div class='alert alert-danger'>Username and password are required!</div>";
    } else {
        // Prepare SQL statement to check admin credentials
        $sql = "SELECT id, password, fullname FROM admins WHERE username = ?";
        $stmt = $conn->prepare($sql);
        
        // Check if the statement was prepared successfully
        if ($stmt) {
            $stmt->bind_param("s", $admin_username);
            $stmt->execute();
            $stmt->store_result(); // Store the result for checking
            
            // Check if the admin exists
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($admin_id, $hashed_password, $fullname); // Add fullname here
                $stmt->fetch();
                
                // Verify the password
                if (password_verify($admin_password, $hashed_password)) {
                    // Password is correct, set session variables
                    $_SESSION['admin_id'] = $admin_id;
                    $_SESSION['fullname'] = $fullname; // Set fullname for dashboard
                    header("Location: admin_dashboard.php"); // Redirect to admin dashboard
                    exit;
                } else {
                    echo "<div class='alert alert-danger'>Invalid username or password!</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Invalid username or password!</div>";
            }
            
            $stmt->close(); // Close the statement
        } else {
            echo "<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>"; // Show error if preparation fails
        }
        
        $conn->close(); // Close the database connection
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Admin Login</h2>
        <form action="admin_login.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="admin_username">Username:</label>
                <input type="text" class="form-control" name="admin_username" id="admin_username" required>
            </div>
            <div class="form-group">
                <label for="admin_password">Password:</label>
                <input type="password" class="form-control" name="admin_password" id="admin_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="mt-3">
            <a href="Login.php" class="btn btn-secondary">Go to User Login</a> <!-- Link to user login -->
            <a href="admin_register.php" class="btn btn-secondary">Register Admin</a> <!-- Link to admin registration -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
