<?php
include('../connect_db.php');

if (isset($_GET['user_id']) && isset($_GET['username'])) {
    $user_id = intval($_GET['user_id']);
    $username = htmlspecialchars($_GET['username']);
} else {
    echo "<p>Invalid student details.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO tblnotifications (user_id, message, status, created_at) VALUES (?, ?, 'unread', NOW())");
        $stmt->bind_param("is", $user_id, $message);
        if ($stmt->execute()) {
            $success = "Reply sent successfully to @$username.";
        } else {
            $error = "Failed to send reply. Please try again.";
        }
    } else {
        $error = "Message cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reply to Student</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .reply-form-container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-weight: 500;
        }
        textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: vertical;
        }
        .submit-btn {
            padding: 10px 18px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #218838;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #333;
            color: #fff;
            padding: 10px 16px;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #444;
        }
        .msg {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="reply-form-container">
        <h2>✉️ Reply to Student: <span style="color:#007bff;">@<?= $username ?></span></h2>

        <?php if (isset($success)): ?>
            <div class="msg success"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
            <div class="msg error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="message">Write your message:</label>
                <textarea name="message" placeholder="Type your reply here..." required></textarea>
            </div>
            <button class="submit-btn" type="submit">Send Reply</button>
        </form>

        <a class="back-btn" href="view_replies.php">← Back to Replies</a>
    </div>
</body>
</html>
