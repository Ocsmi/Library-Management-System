<?php 
session_start();
include('connect_db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: student_dashboard.php');
    exit;
}

$student_id = $_SESSION['user_id'];

// Fetch only pending penalties (status = 'Pending')
$query = "
    SELECT p.penalty_id, p.amount, p.paid, b.title 
    FROM tblpenalties p 
    JOIN tblborrow br ON p.borrow_id = br.borrow_id 
    JOIN tblbooks b ON br.book_id = b.book_id
    WHERE p.user_id = ? AND p.status = 'Pending'  -- Only 'Pending' penalties will show
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Penalty - Mpesa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        form input, form button {
            padding: 8px 12px;
            margin: 5px;
            font-size: 14px;
        }

        form button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #218838;
        }

        .payment-success {
            display: none;
            padding: 20px;
            background-color: #28a745;
            color: white;
            text-align: center;
            margin-top: 20px;
            border-radius: 5px;
        }

        .payment-error {
            display: none;
            padding: 20px;
            background-color: #dc3545;
            color: white;
            text-align: center;
            margin-top: 20px;
            border-radius: 5px;
        }

        .print-button, .return-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .print-button {
            background-color: #007bff;
            color: white;
        }

        .print-button:hover {
            background-color: #0056b3;
        }

        .return-button {
            background-color: #ffc107;
            color: white;
        }

        .return-button:hover {
            background-color: #e0a800;
        }

        /* Print-specific styles */
        @media print {
            body {
                margin: 0;
                padding: 20px;
            }

            h2, table {
                text-align: center;
            }

            table {
                width: 100%;
                border: 1px solid #000;
                border-collapse: collapse;
            }

            table th, table td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            .payment-success, .payment-error {
                display: none;
            }

            .print-button, .return-button {
                display: none;
            }
        }
    </style>
    <script>
        function showPaymentMessage(isSuccess) {
            var successMessage = document.getElementById("payment-success");
            var errorMessage = document.getElementById("payment-error");

            if (isSuccess) {
                successMessage.style.display = "block";
                setTimeout(function() {
                    successMessage.style.display = "none";
                }, 5000);
            } else {
                errorMessage.style.display = "block";
                setTimeout(function() {
                    errorMessage.style.display = "none";
                }, 5000);
            }
        }
    </script>
</head>
<body>

    <h2>Pending Penalties</h2>

    <div id="payment-success" class="payment-success">Payment Successful!</div>
    <div id="payment-error" class="payment-error">Payment Failed. Please try again.</div>

    <table>
        <tr>
            <th>Book Title</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td>Kshs <?= number_format($row['amount'], 2) ?></td>
                <td>
                    <form action="process_payment.php" method="POST" onsubmit="showPaymentMessage(true)">
                        <input type="hidden" name="penalty_id" value="<?= $row['penalty_id'] ?>">
                        <input type="hidden" name="amount" value="<?= $row['amount'] ?>">
                        <input type="text" name="phone_number" placeholder="Enter Mpesa Number" required>
                        <button type="submit">Pay with Mpesa</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Print Button -->
    <button class="print-button" onclick="window.print()">Print Payment Details</button>

    <!-- Return to Dashboard Button -->
    <a href="student_dashboard.php">
        <button class="return-button">Return to Dashboard</button>
    </a>

</body>
</html>
