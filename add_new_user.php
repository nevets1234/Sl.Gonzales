<?php
session_start(); // Start the session

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit;
}

// Include the database connection file
include 'db.php';

// Initialize variables for user input
$fullname = $username = $phone_number = $address = "";
$error_msg = "";
$success_msg = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Hash the password for security

    // Prepare SQL statement to insert user data
    $sql = "INSERT INTO users2 (fullname, username, phone_number, address, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $fullname, $username, $phone_number, $address, $password);
        if ($stmt->execute()) {
            $success_msg = "User added successfully!";
        } else {
            $error_msg = "Error adding user: " . $stmt->error;
        }
        $stmt->close(); // Close the statement
    } else {
        $error_msg = "Error preparing statement: " . $conn->error; // Show error if preparation fails
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Add New User</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Add New User</h2>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_msg); ?></div>
        <?php endif; ?>

        <?php if (!empty($success_msg)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success_msg); ?></div>
        <?php endif; ?>

        <form action="add_new_user.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" class="form-control" name="fullname" id="fullname" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" name="phone_number" id="phone_number" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" name="address" id="address" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>

        <div class="mt-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
