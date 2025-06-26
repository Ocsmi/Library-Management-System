<?php 
session_start();
include('connect_db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: student_dashboard.php');
    exit;
}

$student_id = $_SESSION['user_id'];

// Query to fetch borrowed books with penalty details
$borrowed_books = $conn->query("
    SELECT b.borrow_id, bk.title, bk.author, b.borrow_date, 
           COALESCE(NULLIF(b.return_date, '0000-00-00 00:00:00'), 'Not Returned') AS return_date, 
           b.status, 
           COALESCE(p.amount, 0) AS penalty_amount, 
           COALESCE(NULLIF(p.paid, ''), 'No') AS paid_status, 
           COALESCE(p.penalty_id, 0) AS penalty_id,
           p.status AS penalty_status
    FROM tblborrow b 
    JOIN tblbooks bk ON b.book_id = bk.book_id 
    LEFT JOIN tblpenalties p ON b.borrow_id = p.borrow_id 
    WHERE b.user_id = $student_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Borrowed Books</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="student_dashboard.php">Dashboard</a>
            <a href="borrow_book.php">Browse Books</a>
            <a href="view_borrowed.php">Borrowed Books</a>
            <a href="return_book.php">Return Books</a>
            <a href="mpesa_payment.php">My Transactions</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h1>Borrowed Books</h1>
        <?php if ($borrowed_books->num_rows > 0): ?>
            <table class="borrowed-books-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Penalty</th>
                        <th>Paid</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($book = $borrowed_books->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['borrow_date']) ?></td>
                            <td><?= ($book['return_date'] !== 'Not Returned') ? htmlspecialchars($book['return_date']) : 'Not Returned' ?></td>
                            <td>
                                <?php
                                // Display book status based on the status of the book
                                switch ($book['status']) {
                                    case 'returned':
                                        echo "Awaiting Admin Approval";
                                        break;
                                    case 'approved_return':
                                        echo "Return Approved";
                                        break;
                                    case 'pending':
                                        echo "Pending Return";
                                        break;
                                    default:
                                        echo "Not Returned";
                                }
                                ?>
                            </td>
                            <td><?= ($book['penalty_amount'] > 0) ? 'Kshs ' . number_format($book['penalty_amount'], 2) : 'Kshs 0.00' ?></td>
                            <td>
                                <?php 
                                // Display the penalty payment status meaningfully
                                if ($book['penalty_status'] == 'Paid') {
                                    echo 'Paid';
                                } elseif ($book['penalty_status'] == 'Pending') {
                                    echo 'Pending Approval';
                                } else {
                                    echo 'Not Paid';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($book['penalty_amount'] > 0 && $book['penalty_status'] !== 'Paid'): ?>
                                    <!-- Only show the Pay Now button if the penalty is not paid -->
                                    <a href="mpesa_payment.php?borrow_id=<?= $book['borrow_id'] ?>&penalty_id=<?= $book['penalty_id'] ?>" class="pay-btn">Pay Now</a>
                                <?php else: ?>
                                    <!-- If the penalty is paid or no penalty, show status as Paid or No -->
                                    <?= ($book['penalty_status'] === 'Paid') ? 'Paid' : 'No Penalty' ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No borrowed books found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
