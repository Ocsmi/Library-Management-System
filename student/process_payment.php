<?php 
session_start();
include('connect_db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: view_borrowed.php');
    exit;
}

$student_id = $_SESSION['user_id'];
$penalty_id = $_POST['penalty_id'];
$amount = $_POST['amount'];
$phone_number = $_POST['phone_number'];

// Fetch the borrow_id related to this penalty to ensure it exists
$query = "
    SELECT br.borrow_id 
    FROM tblpenalties p 
    JOIN tblborrow br ON p.borrow_id = br.borrow_id 
    WHERE p.penalty_id = ? AND p.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $penalty_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $borrow_id = $row['borrow_id'];

    // Begin transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        // Insert the transaction record with 'Completed' status
        $transaction_query = "
        INSERT INTO tbltransactions (borrow_id, user_id, amount, phone_number, status, date)
        VALUES (?, ?, ?, ?, 'Completed', NOW())
        ON DUPLICATE KEY UPDATE status = 'Completed'
        ";

        $transaction_stmt = $conn->prepare($transaction_query);
        $transaction_stmt->bind_param('iiis', $borrow_id, $student_id, $amount, $phone_number);
        if (!$transaction_stmt->execute()) {
            throw new Exception("Error inserting transaction record.");
        }

        // Update the penalty to mark it as paid
        $update_penalty_query = "UPDATE tblpenalties SET paid = 'Yes' WHERE penalty_id = ?";
        $update_stmt = $conn->prepare($update_penalty_query);
        $update_stmt->bind_param('i', $penalty_id);
        if (!$update_stmt->execute()) {
            throw new Exception("Error updating penalty status.");
        }

        // Commit the transaction if both queries were successful
        $conn->commit();

        // Redirect to a success page
        header('Location: payment_success.php');
        exit;
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        $conn->rollback();
        
        // Display the error message for debugging
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid borrow record or penalty not found.";
}
?>
