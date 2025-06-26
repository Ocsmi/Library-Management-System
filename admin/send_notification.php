<?php
include('../connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO tblnotifications (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $message);
    $stmt->execute();

    header("Location: send_notification.php?success=1");
    exit();
}

// Fetch students
$students = $conn->query("SELECT * FROM tblusers WHERE role = 'student'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Notification</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 0;
        }

        .notification-container {
            width: 60%;
            max-width: 700px;
            margin: 60px auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .success-msg {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }

        select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 15px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            background-color: #6c757d;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        @media screen and (max-width: 768px) {
            .notification-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="notification-container">
    <h2>Send Notification to Student</h2>

    <?php if (isset($_GET['success'])) : ?>
        <div class="success-msg">✅ Notification sent successfully!</div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="user_id">Select Student:</label>
        <select name="user_id" id="user_id" required>
            <option value="">-- Choose Student --</option>
            <?php while ($student = $students->fetch_assoc()) : ?>
                <option value="<?= $student['user_id'] ?>"><?= htmlspecialchars($student['username']) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="message">Message:</label>
        <textarea name="message" id="message" rows="5" placeholder="Type your message here..." required></textarea>

        <button type="submit">Send Notification</button>
    </form>

    <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

</body>
</html>
