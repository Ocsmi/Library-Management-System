<?php
include('../connect_db.php');

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hash
    $role = 'student';

    $check = $conn->prepare("SELECT * FROM tblusers WHERE username = ?");
    $check->bind_param('s', $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO tblusers (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);

        if ($stmt->execute()) {
            $success = "Account created successfully. Please login.";
            header("Location: login.php?message=" . urlencode($success));
            exit;
        } else {
            $error = "Failed to register. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #8f94fb, #4e54c8);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333333;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4e54c8;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3d42b2;
        }

        .error, .success {
            text-align: center;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .error { color: red; }
        .success { color: green; }

        p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        a {
            color: #4e54c8;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .toggle-password {
            margin-top: -15px;
            margin-bottom: 15px;
            font-size: 13px;
            color: #555;
            cursor: pointer;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h1>Student Registration</h1>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>

    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <div class="toggle-password">
            <input type="checkbox" onclick="togglePassword()"> Show Password
        </div>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
    <p><a href="../index.php">← Return to Homepage</a></p>
</div>

<script>
    function togglePassword() {
        var pwd = document.getElementById("password");
        pwd.type = (pwd.type === "password") ? "text" : "password";
    }
</script>
</body>
</html>
