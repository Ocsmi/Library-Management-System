<?php
session_start();
include('../connect_db.php');

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Approve Return Logic
if (isset($_GET['approve']) && is_numeric($_GET['approve'])) {
    $borrow_id = $_GET['approve'];

    // 1. Update borrow record status to 'returned' and set return_date
    $updateBorrow = $conn->prepare("UPDATE tblborrow SET status = 'returned', return_date = NOW() WHERE borrow_id = ?");
    $updateBorrow->bind_param("i", $borrow_id);
    $updateBorrow->execute();

    // 2. Get the book_id associated with this borrow_id
    $getBook = $conn->prepare("SELECT book_id FROM tblborrow WHERE borrow_id = ?");
    $getBook->bind_param("i", $borrow_id);
    $getBook->execute();
    $result = $getBook->get_result();
    $row = $result->fetch_assoc();
    $book_id = $row['book_id'];

    // 3. Set the book status back to 'available'
    $updateBook = $conn->prepare("UPDATE tblbooks SET status = 'available' WHERE book_id = ?");
    $updateBook->bind_param("i", $book_id);
    $updateBook->execute();

    $success = "Book return approved successfully.";
}

// Fetch all returned books awaiting approval
$sql = "SELECT b.borrow_id, b.user_id, u.username, bk.title, b.return_date, b.status 
        FROM tblborrow b
        JOIN tblbooks bk ON b.book_id = bk.book_id
        JOIN tblusers u ON b.user_id = u.user_id
        WHERE b.status = 'returned'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Return Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 30px;
        }
        h1 {
            color: #333;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #0066cc;
            color: white;
        }
        .btn {
            background-color: #28a745;
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h1>Returned Books Awaiting Approval</h1>

<?php if (isset($success)) : ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Borrow ID</th>
                <th>Student ID</th>
                <th>Username</th>
                <th>Book Title</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['borrow_id'] ?></td>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= $row['return_date'] ?></td>
                    <td><?= $row['status'] === 'returned' ? 'Awaiting Approval' : $row['status'] ?></td>
                    <td><a href="admin_return_approval.php?approve=<?= $row['borrow_id'] ?>" class="btn">Approve Return</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No books are currently awaiting return approval.</p>
<?php endif; ?>

</body>
</html>
