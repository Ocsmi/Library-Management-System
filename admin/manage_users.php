<?php
include('../connect_db.php');

// Fetch all users
$users = $conn->query("SELECT * FROM tblusers");

// Display success or error messages if any
if (isset($_GET['message'])) {
    echo "<p style='color: green;'>".$_GET['message']."</p>";
}
if (isset($_GET['error'])) {
    echo "<p style='color: red;'>".$_GET['error']."</p>";
}

// Handle form submission for adding a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM tblusers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    $error_message = "Username already exists!";
} else {
    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO tblusers (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    $stmt->execute();

    $success_message = "User added successfully!";
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Manage Users</title>
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

                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <h1>Manage Users</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </header>

            <!-- Add User Form -->
            <section class="add-user-form">
                <h2>Add New User</h2>
                <?php if (isset($error_message)) : ?>
                    <p style="color: red;"><?= $error_message ?></p>
                <?php endif; ?>
                <?php if (isset($success_message)) : ?>
                    <p style="color: green;"><?= $success_message ?></p>
                <?php endif; ?>
                <form action="manage_users.php" method="POST">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                   <label for="role">Role:</label>
<select id="role" name="role" required>
    <option value="admin">Admin</option>
    <option value="student">Student</option>
</select>


                    <button type="submit" name="add_user">Add User</button>
                </form>
            </section>

            <!-- Manage Users Section -->
            <section class="manage-users">
                <h2>User List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $users->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $user['user_id'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['role'] ?></td>
                                <td>
                                    <a href="delete_user.php?user_id=<?= $user['user_id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <footer>
        <p>&copy; 2025 College Library. All rights reserved.</p>
    </footer>
</body>
</html>
