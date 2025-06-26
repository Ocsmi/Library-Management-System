<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include('../connect_db.php');

// Fetch borrowed books
$query = "
    SELECT b.borrow_id, u.username AS student, bk.title AS book_title, b.borrow_date, b.status 
    FROM tblborrow b
    JOIN tblusers u ON b.user_id = u.user_id
    JOIN tblbooks bk ON b.book_id = bk.book_id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Borrowed Books</title>
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
                    <li><a href="borrowed_books.php" class="active">View Borrowed Books</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <h1>Borrowed Books</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </header>

            <!-- Borrowed Books Section -->
            <section class="borrowed-books">
                <h2>List of Borrowed Books</h2>
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
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $row['borrow_id'] ?></td>
                                <td><?= $row['student'] ?></td>
                                <td><?= $row['book_title'] ?></td>
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
