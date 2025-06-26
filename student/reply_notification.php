<?php
session_start();
include('connect_db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $reply = $_POST['reply'];
    $notif_id = $_POST['notif_id'];

    // Store reply (optional enhancement: send to admin or store in a new tblreplies table)
    $stmt = $conn->prepare("INSERT INTO tblreplies (user_id, notification_id, reply_message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $notif_id, $reply);
    $stmt->execute();

    header("Location: notifications.php?reply_sent=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reply to Notification</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        .reply-box {
            background: #fff;
            padding: 25px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        textarea {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
            min-height: 100px;
        }

        button {
            margin-top: 15px;
            background: #007bff;
            color: #fff;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a.back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #444;
        }
    </style>
</head>
<body>
    <div class="reply-box">
        <h2>Reply to Notification</h2>
        <form method="POST" action="">
            <input type="hidden" name="notif_id" value="<?= htmlspecialchars($_GET['notif_id']) ?>">
            <textarea name="reply" required placeholder="Write your reply here..."></textarea>
            <br>
            <button type="submit">Send Reply</button>
        </form>
        <a class="back-link" href="notifications.php">← Back to Notifications</a>
    </div>
</body>
</html>
