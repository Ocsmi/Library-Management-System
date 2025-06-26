<?php
include('connect_db.php');

// Read incoming Mpesa response
$mpesa_response = file_get_contents('php://input');
$data = json_decode($mpesa_response, true);

if ($data && isset($data['TransactionID'])) {
    $transaction_id = $data['TransactionID'];
    $amount = $data['Amount'];
    $phone_number = $data['PhoneNumber'];
    $status = $data['ResultCode'] == 0 ? 'Completed' : 'Failed';

    // Update database
    $update_transaction = "UPDATE tbltransactions SET status = ? WHERE transaction_id = ?";
    $stmt = $conn->prepare($update_transaction);
    $stmt->bind_param('ss', $status, $transaction_id);
    $stmt->execute();
}
?>
