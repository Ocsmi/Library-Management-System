<?php
session_start();
include('connect_db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle Mark as Read
if (isset($_GET['mark_read'])) {
    $notif_id = intval($_GET['mark_read']);
    $conn->query("UPDATE tblnotifications SET status = 'read' WHERE notification_id = $notif_id AND user_id = $user_id");
    header("Location: notifications.php?alert=Notification marked as read&type=success");
    exit();
}

// Fetch notifications
$query = $conn->prepare("SELECT * FROM tblnotifications WHERE user_id = ? ORDER BY created_at DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Notifications</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        .notif-container {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        #alertBox {
            display: none;
            padding: 15px;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .notif-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-message {
            font-size: 16px;
            color: #444;
        }

        .notif-date {
            font-size: 14px;
            color: #888;
        }

        .notif-actions {
            margin-top: 10px;
        }

        .notif-actions a {
            margin-right: 10px;
            text-decoration: none;
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
        }

        .mark-read {
            background: #28a745;
            color: #fff;
        }

        .reply-btn {
            background: #007bff;
            color: #fff;
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
    <div class="notif-container">
        <!-- In-page Alert System -->
        <div id="alertBox"></div>

        <!-- Back Button -->
        <a class="back-btn" href="student_dashboard.php">← Back to Dashboard</a>

        <h2>📬 My Notifications</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="notif-item">
                    <div class="notif-message">
                        <?= ($row['status'] == 'unread') ? '<strong>[NEW] </strong>' : '' ?>
                        <?= htmlspecialchars($row['message']) ?>
                    </div>
                    <div class="notif-date">📅 <?= $row['created_at'] ?></div>
                    <div class="notif-actions">
                        <?php if ($row['status'] == 'unread'): ?>
                            <a class="mark-read" href="?mark_read=<?= $row['notification_id'] ?>">Mark as Read</a>
                        <?php endif; ?>
                        <a class="reply-btn" href="reply_notification.php?notif_id=<?= $row['notification_id'] ?>">Reply</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No notifications yet.</p>
        <?php endif; ?>
    </div>

    <script>
        function showAlert(message, type = 'success') {
            const alertBox = document.getElementById('alertBox');
            alertBox.innerText = message;

            if (type === 'error') {
                alertBox.style.background = '#dc3545'; // red
            } else if (type === 'info') {
                alertBox.style.background = '#007bff'; // blue
            } else {
                alertBox.style.background = '#28a745'; // green
            }

            alertBox.style.display = 'block';

            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 5000); // auto hide after 5 seconds
        }

        // Handle alert from PHP GET params
        <?php if (isset($_GET['alert'])): ?>
        document.addEventListener("DOMContentLoaded", function() {
            showAlert("<?= htmlspecialchars($_GET['alert']) ?>", "<?= isset($_GET['type']) ? htmlspecialchars($_GET['type']) : 'success' ?>");
        });
        <?php endif; ?>
    </script>
</body>
</html>
