<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <nav>
                <ul>
                    <li><a href="manage_books.php">Manage Books</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="approve_borrow.php">Approve Borrow Requests</a></li>
                    <li><a href="return_books.php">Manage Returns</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <h1>Dashboard</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </header>

            <!-- Dashboard Overview -->
            <section class="dashboard-info">
                <h2>Dashboard Overview</h2>
                <p>Here you can manage books, users, approve borrow requests, and handle book returns.</p>
                <div class="stats">
                    <div class="stat-box">
                        <h3>Total Books</h3>
                        <p>
                            <?php
                            include('../connect_db.php');
                            $result = $conn->query("SELECT COUNT(*) AS total_books FROM tblbooks");
                            $row = $result->fetch_assoc();
                            echo $row['total_books'];
                            ?>
                        </p>
                    </div>
                    <div class="stat-box">
                        <h3>Total Users</h3>
                        <p>
                            <?php
                            $result = $conn->query("SELECT COUNT(*) AS total_users FROM tblusers");
                            $row = $result->fetch_assoc();
                            echo $row['total_users'];
                            ?>
                        </p>
                    </div>
                    <div class="stat-box">
                        <h3>Pending Borrow Requests</h3>
                        <p>
                            <?php
                            $result = $conn->query("SELECT COUNT(*) AS pending_requests FROM tblborrow WHERE status = 'pending'");
                            $row = $result->fetch_assoc();
                            echo $row['pending_requests'];
                            ?>
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <footer>
        <p>&copy; 2025 College Library. All rights reserved.</p>
    </footer>
</body>
</html>
