<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include('connect_db.php');

// Fetch user details
$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT * FROM tblusers WHERE user_id = ?");
$user_query->bind_param('i', $user_id);
$user_query->execute();
$user = $user_query->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Student Dashboard</title>
</head>
<body>
    <header>
        <nav>
            <a href="student_dashboard.php">Dashboard</a>
            <a href="borrow_book.php">Browse Books</a>
            <a href="view_borrowed.php">Borrowed Books</a>
            <a href="return_book.php">Return Books</a>
            <a href="mpesa_payment.php">My Transactions</a>
            <a href="notifications.php">My Notifications</a>

            <a href="student_profile.php" class="active">Profile</a>

            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h1>Welcome, <?= htmlspecialchars($user['username']) ?></h1>
        <p>Your role: <?= htmlspecialchars($user['role']) ?></p>
    </main>

 <div class="container">
        <p>Manage your library activities with ease:</p>
        <ul>
            <li>Browse available books and borrow them.</li>
            <li>Track your borrowed books and return them on time.</li>
            <li>Check and pay any penalties for overdue books.</li>
    </div>

    <footer>
        <p>&copy; 2025 College Library. All rights reserved.</p>
    </footer>
</body>
</html>
