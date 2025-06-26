<?php
include('../connect_db.php');

if (isset($_GET['borrow_id'])) {
    $borrow_id = $_GET['borrow_id'];

    // Update status to 'returned' after admin approves
    $update_query = "UPDATE tblborrow SET status = 'returned' WHERE borrow_id = ?";
    
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $borrow_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Book marked as returned successfully.');</script>";
    } else {
        echo "<script>alert('Error updating return status.');</script>";
    }

    $stmt->close();
    $conn->close();
}

// Redirect back to return_books.php
header("Location: return_books.php");
exit();
?>
