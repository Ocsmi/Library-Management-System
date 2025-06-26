<?php
include('../connect_db.php');

if (isset($_GET['borrow_id']) && isset($_GET['action'])) {
    $borrow_id = $_GET['borrow_id'];
    $action = $_GET['action'];

    if ($action == 'approve') {
        $status = 'approved';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    } else {
        die("Invalid action.");
    }

    // Update the borrow request status
    $stmt = $conn->prepare("UPDATE tblborrow SET status = ? WHERE borrow_id = ?");
    $stmt->bind_param('si', $status, $borrow_id);
    $stmt->execute();

    // Redirect back to the approve borrow page
    header("Location: approve_borrow.php");
    exit();
}
