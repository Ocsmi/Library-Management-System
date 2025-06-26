<?php
session_start();
include('connect_db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: student_dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $borrow_id = $_POST['borrow_id'];

    // Fetch the borrowing record
    $stmt = $conn->prepare("SELECT borrow_date, return_date, TIMESTAMPDIFF(DAY, return_date, NOW()) AS overdue_days FROM tblborrow WHERE borrow_id = ?");
    $stmt->bind_param("i", $borrow_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $borrow = $result->fetch_assoc();

    if ($borrow) {
        $overdue_days = ($borrow['overdue_days'] > 0) ? $borrow['overdue_days'] : 0;
        $penalty_amount = $overdue_days * 50.00;

        // Update return date and status first
        $updateStmt = $conn->prepare("UPDATE tblborrow SET status = 'returned', return_date = NOW() WHERE borrow_id = ?");
        $updateStmt->bind_param("i", $borrow_id);
        $updateStmt->execute();

        if ($penalty_amount > 0) {
            // Insert into tblpenalties
            $penaltyStmt = $conn->prepare("INSERT INTO tblpenalties (borrow_id, amount, paid) VALUES (?, ?, 0)");
            $penaltyStmt->bind_param("id", $borrow_id, $penalty_amount);
            $penaltyStmt->execute();

            // Update penalty_id in tblborrow
            $penalty_id = $conn->insert_id;
            $updatePenalty = $conn->prepare("UPDATE tblborrow SET penalty_id = ? WHERE borrow_id = ?");
            $updatePenalty->bind_param("ii", $penalty_id, $borrow_id);
            $updatePenalty->execute();
        }

        $success = "Book returned successfully. Awaiting admin approval.";
    } else {
        $error = "Invalid borrow record selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Return Book</title>
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
        <h1>Return Book</h1>

        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <label for="borrow_id">Select Borrowed Book:</label>
            <select name="borrow_id" id="borrow_id" required>
                <option value="">-- Select a Book to Return --</option>
                <?php
                $student_id = $_SESSION['user_id'];
                $query = "SELECT b.borrow_id, bk.title FROM tblborrow b
                          JOIN tblbooks bk ON b.book_id = bk.book_id
                          WHERE b.user_id = ? AND b.status = 'approved'";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $student_id);
                $stmt->execute();
                $borrowed_books = $stmt->get_result();

                while ($row = $borrowed_books->fetch_assoc()) {
                    echo "<option value='{$row['borrow_id']}'>{$row['title']}</option>";
                }
                ?>
            </select>
            <button type="submit">Return Book</button>
        </form>
    </div>
</body>
</html>
