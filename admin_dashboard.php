<?php
session_start(); // Start the session

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['admin_id'])) { // Check for admin_id in session
    header("Location: admin_login.php"); // Redirect to the admin login page
    exit;
}

// Include the database connection file
include 'db.php';

// Fetch the admin's username or other data if needed
$admin_id = $_SESSION['admin_id'];

// You can query additional information if required
$sql = "SELECT username FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        
        <div class="mt-4">
            <h4>Admin Options</h4>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="view_all_users.php" class="btn btn-primary btn-block">View All Users</a> <!-- Link to view all users -->
                </li>
                <li class="list-group-item">
                    <a href="view_appointments.php" class="btn btn-info btn-block">View Appointments</a>
                </li>
                <!-- Add more admin options here as needed -->
            </ul>
        </div>

        <div class="mt-3">
            <a href="logout.php" class="btn btn-danger">Logout</a> <!-- Logout button -->
        </div>
    </div>

    <footer class="text-center mt-4">
        <p>&copy; 2024 Health Center. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
