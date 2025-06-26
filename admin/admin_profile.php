<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include('../connect_db.php');

// Fetch current admin info
$admin_id = $_SESSION['admin_id'];
$query = $conn->prepare("SELECT * FROM tblusers WHERE user_id = ?");
$query->bind_param("i", $admin_id);
$query->execute();
$result = $query->get_result();
$admin = $result->fetch_assoc();

// Handle profile update
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update Username
    if (isset($_POST['update_username'])) {
        $new_username = trim($_POST['new_username']);

        if (!empty($new_username)) {
            // Check if username already exists
            $check = $conn->prepare("SELECT * FROM tblusers WHERE username = ? AND user_id != ?");
            $check->bind_param("si", $new_username, $admin_id);
            $check->execute();
            $check_result = $check->get_result();

            if ($check_result->num_rows > 0) {
                $error = "Username already taken!";
            } else {
                $update = $conn->prepare("UPDATE tblusers SET username = ? WHERE user_id = ?");
                $update->bind_param("si", $new_username, $admin_id);
                $update->execute();
                $success = "Username updated successfully!";
                $_SESSION['username'] = $new_username;
                $admin['username'] = $new_username;
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
            $update->bind_param("si", $new_password, $admin_id);
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
    <link rel="stylesheet" href="css/style.css">
    <title>Admin Profile</title>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_books.php">Manage Books</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="approve_borrow.php">Approve Borrow Requests</a></li>
                    <li><a href="return_books.php">Manage Returns</a></li>
                    <li><a href="borrowed_books.php">View Borrowed Books</a></li>
                    <li><a href="admin_transactions.php">Transaction History</a></li>
                    <li><a href="admin_profile.php" class="active">Profile</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <h1>Admin Profile</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </header>

            <section class="profile-section">
                <h2>Profile Details</h2>

                <?php if ($success): ?>
                    <p style="color: green;"><?= $success ?></p>
                <?php endif; ?>
                <?php if ($error): ?>
                    <p style="color: red;"><?= $error ?></p>
                <?php endif; ?>

                <div class="profile-info">
                    <p><strong>Current Username:</strong> <?= htmlspecialchars($admin['username']) ?></p>
                </div>

                <div class="profile-forms">
                    <h3>Update Username</h3>
                    <form action="admin_profile.php" method="POST">
                        <input type="text" name="new_username" placeholder="New Username" required>
                        <button type="submit" name="update_username">Update Username</button>
                    </form>

                    <h3>Update Password</h3>
                    <form action="admin_profile.php" method="POST">
                        <input type="password" name="new_password" placeholder="New Password" required>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                        <button type="submit" name="update_password">Update Password</button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <footer>
        <p>&copy; 2025 College Library. All rights reserved.</p>
    </footer>
</body>
</html>
