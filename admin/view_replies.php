<?php
include('../connect_db.php');

$query = $conn->query("
    SELECT r.reply_message, r.created_at AS reply_date, u.username, u.user_id, n.message AS original_message
    FROM tblreplies r
    INNER JOIN tblnotifications n ON r.notification_id = n.notification_id
    INNER JOIN tblusers u ON r.user_id = u.user_id
    ORDER BY r.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Replies</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .replies-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .reply-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .reply-item:last-child {
            border-bottom: none;
        }
        .reply-message {
            font-size: 15px;
            color: #444;
        }
        .original-msg {
            font-size: 14px;
            color: #777;
            margin-bottom: 5px;
        }
        .student-name {
            color: #0066cc;
            font-weight: bold;
        }
        .reply-date {
            font-size: 13px;
            color: #aaa;
        }
        .reply-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .reply-btn:hover {
            background-color: #0056b3;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            background: #333;
            color: #fff;
            padding: 10px 18px;
            border-radius: 4px;
        }
        .back-btn:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <div class="replies-container">
        <a class="back-btn" href="admin_dashboard.php">← Back to Dashboard</a>
        <h2>📨 Student Replies to Notifications</h2>

        <?php if ($query->num_rows > 0): ?>
            <?php while($row = $query->fetch_assoc()): ?>
                <div class="reply-item">
                    <div class="student-name">@<?= htmlspecialchars($row['username']) ?></div>
                    <div class="original-msg"><strong>🔔 Original Notification:</strong> <?= htmlspecialchars($row['original_message']) ?></div>
                    <div class="reply-message"><strong>💬 Reply:</strong> <?= htmlspecialchars($row['reply_message']) ?></div>
                    <div class="reply-date">📅 <?= $row['reply_date'] ?></div>
                    <a class="reply-btn" href="reply_to_student.php?user_id=<?= $row['user_id'] ?>&username=<?= urlencode($row['username']) ?>">Reply to Student</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No replies received yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
