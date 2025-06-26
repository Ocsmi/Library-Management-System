<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include('connect_db.php');

// Fetch current user info
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT * FROM tblusers WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Handle profile update
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update Username
    if (isset($_POST['update_username'])) {
        $new_username = trim($_POST['new_username']);

        if (!empty($new_username)) {
            // Check if username exists
            $check = $conn->prepare("SELECT * FROM tblusers WHERE username = ? AND user_id != ?");
            $check->bind_param("si", $new_username, $user_id);
            $check->execute();
            $check_result = $check->get_result();

            if ($check_result->num_rows > 0) {
                $error = "Username already taken!";
            } else {
                $update = $conn->prepare("UPDATE tblusers SET username = ? WHERE user_id = ?");
                $update->bind_param("si", $new_username, $user_id);
                $update->execute();
                $success = "Username updated successfully!";
                $_SESSION['username'] = $new_username;
                $user['username'] = $new_username;
            }
        } else {
            $error = "Username cannot be empty!";
        }
    }

    // Update Password
    if (isset($_POST['update_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (!empty($new_password) && $new_password === $confirm_password) {
            $update = $conn->prepare("UPDATE tblusers SET password = ? WHERE user_id = ?");
            $update->bind_param("si", $new_password, $user_id);
            $update->execute();
            $success = "Password updated successfully!";
        } else {
            $error = "Passwords do not match or are empty!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Student Profile</title>
</head>
<body>

<header>
    <nav>
        <a href="student_dashboard.php">Dashboard</a>
        <a href="borrow_book.php">Browse Books</a>
        <a href="view_borrowed.php">Borrowed Books</a>
        <a href="return_book.php">Return Books</a>
        <a href="mpesa_payment.php">My Transactions</a>
        <a href="student_profile.php" class="active">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <h1>Student Profile</h1>

    <?php if ($success): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <div class="profile-info">
        <p><strong>Current Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Your Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
    </div>

    <div class="profile-forms">
        <h3>Update Username</h3>
        <form action="student_profile.php" method="POST">
            <input type="text" name="new_username" placeholder="New Username" required>
            <button type="submit" name="update_username">Update Username</button>
        </form>

        <h3>Update Password</h3>
        <form action="student_profile.php" method="POST">
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="update_password">Update Password</button>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2025 College Library. All rights reserved.</p>
</footer>

</body>
</html>
