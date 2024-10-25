<?php
include 'db.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit;
}

// Check if the user ID is provided in the URL
if (isset($_GET['ID'])) {
    $user_id = $_GET['ID'];

    // Prepare the delete statement
    $delete_query = "DELETE FROM users2 WHERE ID = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $user_id);

    // Execute the deletion and check for success
    if ($delete_stmt->execute()) {
        // Redirect back with success message
        header("Location: view_all_users.php?deleted=true");
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    // Redirect if no user ID is provided
    header("Location: view_all_users.php");
    exit;
}

// Close the prepared statement and connection
$delete_stmt->close();
$conn->close();
?>
