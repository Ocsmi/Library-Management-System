<?php
session_start();
include('../connect_db.php');

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['penalty_id']) && isset($_GET['action'])) {
    $penalty_id = $_GET['penalty_id'];
    $action = $_GET['action'];

    // Begin a transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        // Check if the penalty exists
        $query = "SELECT * FROM tblpenalties WHERE penalty_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $penalty_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $penalty = $result->fetch_assoc();

            // Update the transaction status if it exists
            if ($action === 'approve') {
                // Update the penalty status to 'Paid'
                $update_penalty = "UPDATE tblpenalties SET status = 'Paid' WHERE penalty_id = ?";
                $stmt = $conn->prepare($update_penalty);
                $stmt->bind_param("i", $penalty_id);
                $stmt->execute();

                // Update the corresponding transaction to 'Completed'
                $update_transaction = "UPDATE tbltransactions SET status = 'Completed' WHERE penalty_id = ?";
                $stmt = $conn->prepare($update_transaction);
                $stmt->bind_param("i", $penalty_id);
                $stmt->execute();

                // Commit the transaction
                $conn->commit();

                // Redirect back with success message
                header('Location: admin_transactions.php?status=approved');
                exit;
            } elseif ($action === 'reject') {
                // Reject the penalty
                $update_penalty = "UPDATE tblpenalties SET status = 'Rejected' WHERE penalty_id = ?";
                $stmt = $conn->prepare($update_penalty);
                $stmt->bind_param("i", $penalty_id);
                $stmt->execute();

                // Commit the transaction
                $conn->commit();

                // Redirect back with rejected message
                header('Location: admin_transactions.php?status=rejected');
                exit;
            }
        } else {
            // If the penalty doesn't exist, rollback and redirect
            $conn->rollback();
            header('Location: admin_transactions.php?status=error');
            exit;
        }
    } catch (Exception $e) {
        // In case of an error, rollback
        $conn->rollback();
        header('Location: admin_transactions.php?status=error');
        exit;
    }
}
?>
