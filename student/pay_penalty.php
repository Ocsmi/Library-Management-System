<?php
session_start();
include('connect_db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: student_dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrow_id'], $_POST['amount'])) {
    $borrow_id = $_POST['borrow_id'];
    $amount = $_POST['amount'];

    // Simulate payment processing (You can integrate a real payment gateway here)
    $payment_success = true; // Assume the payment is successful for now

    if ($payment_success) {
        // Update the penalty status in the database
        $stmt = $conn->prepare("UPDATE tblpenalties SET paid = 'Yes' WHERE borrow_id = ?");
        $stmt->bind_param("i", $borrow_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Payment successful!";
        } else {
            $_SESSION['message'] = "Payment failed. Try again!";
        }
        $stmt->close();
    }

    header('Location: view_borrowed.php');
    exit;
} else {
    $_SESSION['message'] = "Invalid request.";
    header('Location: view_borrowed.php');
    exit;
}
?>
