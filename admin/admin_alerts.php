<?php
include('../connect_db.php');

// Fetch replies directly
$alerts = $conn->query("
    SELECT r.reply_message, r.created_at AS reply_date, u.username
    FROM tblreplies r
    INNER JOIN tblusers u ON r.user_id = u.user_id
    ORDER BY r.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Alerts</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            padding: 30px;
        }
        .alert-box {
            background: #fff;
            padding: 25px;
            max-width: 800px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .alert-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .alert-item:last-child {
            border-bottom: none;
        }
        .alert-message {
            font-size: 16px;
            color: #444;
        }
        .alert-time {
            font-size: 14px;
            color: #888;
        }
        .student-name {
            font-weight: bold;
            color: #0077cc;
        }
        a.back-btn {
            display: inline-block;
            margin-top: 20px;
            background: #444;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="alert-box">
        <h2>📢 Student Reply Alerts</h2>
        <?php if ($alerts->num_rows > 0): ?>
            <?php while ($row = $alerts->fetch_assoc()): ?>
                <div class="alert-item">
                    <div class="student-name">👤 <?= htmlspecialchars($row['username']) ?></div>
                    <div class="alert-message">💬 <?= htmlspecialchars($row['reply_message']) ?></div>
                    <div class="alert-time">📅 <?= $row['reply_date'] ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No student replies yet.</p>
        <?php endif; ?>
        <a class="back-btn" href="admin_dashboard.php">← Back to Admin Dashboard</a>
    </div>
</body>
</html>
