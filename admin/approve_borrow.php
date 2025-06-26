<?php
include('../connect_db.php');

// Fetch pending borrow requests with student details and book title
$requests = $conn->query("
    SELECT tblborrow.borrow_id, tblusers.username AS student, tblbooks.title AS book, 
           tblborrow.borrow_date, tblborrow.status 
    FROM tblborrow
    INNER JOIN tblusers ON tblborrow.user_id = tblusers.user_id
    INNER JOIN tblbooks ON tblborrow.book_id = tblbooks.book_id
    WHERE tblborrow.status = 'pending'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Approve Borrow</title>
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
                <h1>Approve Borrow Requests</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </header>

            <!-- Approve Borrow Section -->
            <section class="approve-borrow">
                <h2>Pending Borrow Requests</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Borrow ID</th>
                            <th>Student</th>
                            <th>Book</th>
                            <th>Borrow Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($request = $requests->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $request['borrow_id'] ?></td>
                                <td><?= $request['student'] ?></td> <!-- Display student's username -->
                                <td><?= $request['book'] ?></td> <!-- Display book title -->
                                <td><?= $request['borrow_date'] ?></td>
                                <td><?= $request['status'] ?></td>
                                <td>
                                    <a href="approve_request.php?borrow_id=<?= $request['borrow_id'] ?>&action=approve">Approve</a>
                                    <a href="approve_request.php?borrow_id=<?= $request['borrow_id'] ?>&action=reject">Reject</a>
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
