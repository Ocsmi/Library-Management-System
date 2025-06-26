<?php
// admin/index.php
session_start();
include('../connect_db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

echo "<h1>Admin Dashboard</h1>";
echo "<h2>Pending Borrow Requests</h2>";

$sql = "SELECT * FROM tblborrowed_books JOIN tblbooks ON tblborrowed_books.book_id = tblbooks.book_id WHERE tblborrowed_books.is_approved = 0";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div>";
    echo "<p>Book: " . $row['title'] . "</p>";
    echo "<p>User: " . $row['username'] . "</p>";
    echo "<a href='approve_borrow.php?borrow_id=" . $row['borrow_id'] . "'>Approve</a>";
    echo "</div>";
}
?>
