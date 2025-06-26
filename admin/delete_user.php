<?php
include('../connect_db.php');

// Check if user ID is provided
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Delete user from the database
    $stmt = $conn->prepare("DELETE FROM tblusers WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Redirect back to manage users page with a success message
    header("Location: manage_users.php?message=User deleted successfully");
    exit();
} else {
    // Redirect if no user ID is provided
    header("Location: manage_users.php?error=No user ID provided");
    exit();
}
?>
