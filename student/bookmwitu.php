<?php
session_start();
include('connect_db.php');

// Check if the student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php');
    exit;
}

$student_id = $_SESSION['user_id'];

// Fetch books that are NOT currently borrowed or pending by another student
$books = $conn->query("
    SELECT * FROM tblbooks 
    WHERE book_id NOT IN (
        SELECT book_id FROM tblborrow 
        WHERE status IN ('pending', 'approved')
    )
");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];

    // Insert borrow request
    $sql = "INSERT INTO tblborrow (user_id, book_id, borrow_date, status) VALUES (?, ?, NOW(), 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $student_id, $book_id);
    if ($stmt->execute()) {
        // Optional: update status in tblbooks (depends on your system design)
        $update_sql = "UPDATE tblbooks SET status = 'pending' WHERE book_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param('i', $book_id);
        $update_stmt->execute();

        $success = "Book borrow request submitted successfully.";
    } else {
        $error = "Failed to submit borrow request.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Books</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9fafc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 60px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            padding: 30px 40px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .navigation {
            text-align: right;
            margin-bottom: 15px;
        }

        .navigation .btn {
            background-color: #4a90e2;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .success {
            background-color: #e0f8e9;
            color: #1c7c38;
            border-left: 5px solid #3cba54;
            padding: 10px;
            margin-bottom: 15px;
        }

        .error {
            background-color: #ffe7e7;
            color: #d8000c;
            border-left: 5px solid #ff4d4d;
            padding: 10px;
            margin-bottom: 15px;
        }

        form {
            margin-top: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-bottom: 20px;
        }

        button {
            width: 100%;
            background-color: #4a90e2;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #357ABD;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="navigation">
        <a href="student_dashboard.php" class="btn">Return to Dashboard</a>
    </div>

    <h1>Borrow a Book</h1>

    <?php if (isset($success)) echo "<p class='success'>{$success}</p>"; ?>
    <?php if (isset($error)) echo "<p class='error'>{$error}</p>"; ?>

    <form method="POST">
        <label for="book_id">Select Book:</label>
        <select name="book_id" id="book_id" required>
            <option value="">-- Select a Book --</option>
            <?php while ($book = $books->fetch_assoc()) : ?>
                <option value="<?= $book['book_id'] ?>">
                    <?= htmlspecialchars($book['title']) ?> by <?= htmlspecialchars($book['author']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Submit Borrow Request</button>
    </form>
</div>

</body>
</html>
