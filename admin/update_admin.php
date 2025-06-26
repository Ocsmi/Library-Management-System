<?php
include('connect_db.php');

$username = 'admin';
$new_password = 'admin';
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$sql = "UPDATE tblusers SET password = ? WHERE username = ? AND role = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $hashed_password, $username);

if ($stmt->execute()) {
    echo "Admin password updated successfully.";
} else {
    echo "Error updating admin password: " . $conn->error;
}
?>
