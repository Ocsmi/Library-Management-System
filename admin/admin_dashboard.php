<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include('../connect_db.php');
?>
<?php
$count_query = $conn->query("SELECT COUNT(*) AS total FROM tbladmin_notifications");
$count_result = $count_query->fetch_assoc();
$alert_count = $count_result['total'];
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
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_books.php">Manage Books</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="approve_borrow.php">Approve Borrow Requests</a></li>
                    <li><a href="return_books.php">Manage Returns</a></li>
                    <li><a href="borrowed_books.php">View Borrowed Books</a></li>
                    <li><a href="admin_transactions.php">Transaction History</a></li>
                    <li><a href="send_notification.php">Send Notifications</a></li>
                    <li><a href="view_replies.php">View Student Replies</a></li>

                    <li><a href="admin_profile.php" class="active">Profile</a></li>

                </ul>
            </nav>

                <li>
    <a href="admin_alerts.php">🔔 Alerts 
        <?php if ($alert_count > 0): ?>
            <span style="background: red; color: white; padding: 3px 8px; border-radius: 12px; font-size: 12px; margin-left: 5px;">
                <?= $alert_count ?>
            </span>
        <?php endif; ?>
    </a>
</li>


        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <h1>Admin Dashboard</h1>
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

            <!-- Borrowed Books Section -->
            <section class="borrowed-books">
                <h2>Recent Borrowed Books</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Borrow ID</th>
                            <th>Student</th>
                            <th>Book Title</th>
                            <th>Borrow Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "
                            SELECT b.borrow_id, u.username AS student, bk.title AS book_title, b.borrow_date, b.status 
                            FROM tblborrow b
                            JOIN tblusers u ON b.user_id = u.user_id
                            JOIN tblbooks bk ON b.book_id = bk.book_id
                            ORDER BY b.borrow_id DESC
                        ";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) :
                        ?>
                            <tr>
                                <td><?= $row['borrow_id'] ?></td>
                                <td><?= htmlspecialchars($row['student']) ?></td>
                                <td><?= htmlspecialchars($row['book_title']) ?></td>
                                <td><?= $row['borrow_date'] ?></td>
                                <td><?= ucfirst($row['status']) ?></td>
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
