<?php
session_start();
include('../connect_db.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch penalties awaiting approval
$penalties_query = "
    SELECT p.penalty_id, p.borrow_id, p.amount, p.paid, u.name, u.email, b.title
    FROM tblpenalties p
    JOIN tblborrow b ON p.borrow_id = b.borrow_id
    JOIN tblusers u ON b.user_id = u.user_id
    WHERE p.paid = 'No'
    ORDER BY p.penalty_id DESC
";

$result = $conn->query($penalties_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Approval - Payments</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_transactions.php">Transaction History</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h1>Admin Approval - Pending Payments</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Book Title</th>
                        <th>Penalty Amount</th>
                        <th>Status</th>
                        <th>Approve</th>
                        <th>Reject</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['email']) ?>)</td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td>Kshs <?= number_format($row['amount'], 2) ?></td>
                            <td><?= ($row['paid'] === 'Yes') ? 'Paid' : 'Not Paid' ?></td>
                            <td>
                                <a href="approve_payment.php?penalty_id=<?= $row['penalty_id'] ?>&action=approve" class="approve-btn">Approve</a>
                            </td>
                            <td>
                                <a href="approve_payment.php?penalty_id=<?= $row['penalty_id'] ?>&action=reject" class="reject-btn">Reject</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pending payments to approve.</p>
        <?php endif; ?>
    </div>
</body>
</html>
