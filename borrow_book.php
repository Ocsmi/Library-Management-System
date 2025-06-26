<?php
include('connect_db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the user is not logged in
    header('Location: student/login.php');
    exit;
}

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $user_id = $_SESSION['user_id'];

    // Update the book status to 'borrowed'
    $update_book = $conn->prepare("UPDATE tblbooks SET status = 'borrowed' WHERE book_id = ?");
    $update_book->bind_param('i', $book_id);
    $update_book->execute();

    // Insert borrowing record
    $insert_borrow = $conn->prepare("INSERT INTO tblborrow (user_id, book_id, borrow_date) VALUES (?, ?, NOW())");
    $insert_borrow->bind_param('ii', $user_id, $book_id);
    $insert_borrow->execute();

    // Redirect to student dashboard
    header('Location: student/student_dashboard.php');
    exit;
} else {
    echo "No book selected to borrow.";
}
?>
