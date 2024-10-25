<?php
include 'db.php'; // Ensure this is included to connect to the database
session_start(); // Start session

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user profile information for editing
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT fullname, phone_number, address, username FROM users2 WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $phone_number, $address, $username);
$stmt->fetch();
$stmt->close();

// Handle profile update submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_fullname = $_POST['fullname'];
    $new_phone_number = $_POST['phone_number'];
    $new_address = $_POST['address'];
    $new_username = $_POST['username'];

    // Update user profile in the database
    $update_stmt = $conn->prepare("UPDATE users2 SET fullname = ?, phone_number = ?, address = ?, username = ? WHERE id = ?");
    $update_stmt->bind_param("ssssi", $new_fullname, $new_phone_number, $new_address, $new_username, $user_id);

    if ($update_stmt->execute()) {
        // Redirect to the profile view page after successful update
        header("Location: view_profile.php?profile_updated=true");
        exit;
    } else {
        echo "Error: " . $update_stmt->error;
    }
    $update_stmt->close(); // Close the update statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Profile</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Profile</h2>
        <form method="POST">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($address); ?></textarea>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
