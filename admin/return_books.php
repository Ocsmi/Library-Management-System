<?php
include('../connect_db.php');

// Fetch books pending approval OR books marked as returned
$sql = "
    SELECT b.borrow_id, b.user_id AS student_id, bk.book_id, bk.title, b.return_date, b.status, 
           IFNULL(p.amount, 0) AS penalty_amount, p.paid
    FROM tblborrow b
    JOIN tblbooks bk ON b.book_id = bk.book_id
    LEFT JOIN tblpenalties p ON b.borrow_id = p.borrow_id
    WHERE b.status IN ('pending', 'returned')
";
$returned_books = $conn->query($sql);

if (!$returned_books) {
    die("Query Error: " . $conn->error);
}

// Approve return logic
if (isset($_GET['approve']) && isset($_GET['borrow_id'])) {
    $borrow_id = intval($_GET['borrow_id']);

    // Check if book is overdue
    $overdue_check_sql = "SELECT user_id, DATEDIFF(NOW(), borrow_date) AS days_overdue FROM tblborrow WHERE borrow_id = ?";
    $stmt = $conn->prepare($overdue_check_sql);
    $stmt->bind_param('i', $borrow_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $student_id = $row['user_id'];
    $days_overdue = $row['days_overdue'];

    if ($days_overdue > 5) {
        $fine_amount = ($days_overdue - 5) * 1; // $1 per extra day

        // Check if penalty already exists
        $check_penalty_sql = "SELECT penalty_id FROM tblpenalties WHERE borrow_id = ?";
        $check_stmt = $conn->prepare($check_penalty_sql);
        $check_stmt->bind_param('i', $borrow_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            // Insert penalty record
            $insert_penalty_sql = "INSERT INTO tblpenalties (borrow_id, user_id, amount, paid) VALUES (?, ?, ?, 'No')";
            $stmt = $conn->prepare($insert_penalty_sql);
            $stmt->bind_param('iid', $borrow_id, $student_id, $fine_amount);
            $stmt->execute();
        }
    }

    // Update borrow record to mark as approved return
    $update_sql = "UPDATE tblborrow SET status = 'approved_return', return_date = NOW() WHERE borrow_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('i', $borrow_id);
    $stmt->execute();

    // Update book status to 'available'
    $book_update_sql = "UPDATE tblbooks SET status = 'available' WHERE book_id = (SELECT book_id FROM tblborrow WHERE borrow_id = ?)";
    $stmt = $conn->prepare($book_update_sql);
    $stmt->bind_param('i', $borrow_id);
    $stmt->execute();

    echo "<script>alert('Return approved successfully!'); window.location.href = 'return_books.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Manage Returned Books</title>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_books.php">Manage Books</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="approve_borrow.php">Approve Borrow Requests</a></li>
                    <li><a href="return_books.php">Manage Return</a></li>
                    <li><a href="borrowed_books.php">View Borrowed Books</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <h1>Manage Returned Books</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </header>

            <section class="returned-books">
                <h2>Returned Books Awaiting Approval</h2>
                <?php if ($returned_books->num_rows > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Borrow ID</th>
                                <th>Student ID</th>
                                <th>Book Title</th>
                                <th>Return Date</th>
                                <th>Penalty Amount</th>
                                <th>Paid</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($book = $returned_books->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= $book['borrow_id'] ?></td>
                                    <td><?= $book['student_id'] ?></td>
                                    <td><?= htmlspecialchars($book['title']) ?></td>
                                    <td><?= ($book['return_date']) ? htmlspecialchars($book['return_date']) : 'Not Returned' ?></td>
                                    <td><?= ($book['penalty_amount'] > 0) ? "$" . number_format($book['penalty_amount'], 2) : 'None' ?></td>
                                    <td><?= ($book['paid'] === 'Yes') ? 'Yes' : 'No' ?></td>
                                    <td>
                                        <?php
                                        if ($book['status'] === 'pending') {
                                            echo "Pending Approval";
                                        } elseif ($book['status'] === 'returned') {
                                            echo "Returned (Awaiting Approval)";
                                        } elseif ($book['status'] === 'approved_return') {
                                            echo "Return Approved";
                                        } else {
                                            echo ucfirst($book['status']);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($book['status'] === 'returned') : ?>
                                            <a href="return_books.php?approve=1&borrow_id=<?= $book['borrow_id'] ?>" class="btn btn-approve">Approve Return</a>
                                        <?php else : ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No returned books awaiting approval.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <footer>
        <p>&copy; 2025 College Library. All rights reserved.</p>
    </footer>
</body>
</html>
