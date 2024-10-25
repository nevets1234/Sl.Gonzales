<?php
include 'db.php'; // Ensure this is included to connect to the database

// Start session
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all users from the database
$sql = "SELECT * FROM users2";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Admin Dashboard</h2>
        
        <div class="mt-4">
            <h4>All Registered Users</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($user = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($user['fullname']) . "</td>
                                    <td>" . htmlspecialchars($user['username']) . "</td>
                                    <td>" . htmlspecialchars($user['phone_number']) . "</td>
                                    <td>" . htmlspecialchars($user['address']) . "</td>
                                    <td>
                                        <a href='edit_user.php?id=" . $user['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='delete_user.php?id=" . $user['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Go to Registration</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
