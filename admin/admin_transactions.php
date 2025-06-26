<?php
session_start();
include('../connect_db.php');

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Automatically update transactions to 'Completed' if not already
$update_query = "UPDATE tbltransactions SET status = 'Completed' WHERE status != 'Completed'";
$conn->query($update_query);

// Set default date range to show all transactions
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Build query with date filter
$sql = "SELECT t.transaction_id, t.user_id, t.amount, t.phone_number, t.status, t.date, p.penalty_id
        FROM tbltransactions t
        LEFT JOIN tblpenalties p ON t.penalty_id = p.penalty_id
        WHERE 1";

if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND t.date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
}
$sql .= " ORDER BY t.date DESC";

$result = $conn->query($sql);

// Calculate total revenue within the selected date range
$total_query = "SELECT SUM(t.amount) AS total_revenue 
                FROM tbltransactions t
                WHERE t.status = 'Completed'";

if (!empty($start_date) && !empty($end_date)) {
    $total_query .= " AND t.date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
}

$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_revenue = $total_row['total_revenue'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
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

        form {
            text-align: center;
            margin-bottom: 20px;
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

        .alert {
            text-align: center;
            padding: 10px;
            font-size: 16px;
        }

        .total-revenue {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            font-weight: bold;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .print-button:hover {
            background-color: #0056b3;
        }

        .return-button {
            display: block;
            margin: 20px auto;
            background-color: #ffc107;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
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

            h2, .total-revenue {
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

            table th {
                background-color: #f2f2f2;
            }

            .print-button {
                display: none;
            }

            .return-button {
                display: none;
            }
        }
    </style>
</head>
<body>

    <h2>Transaction History</h2>

    <!-- Display success or error message based on URL status -->
    <?php if (isset($_GET['status'])): ?>
        <div class="alert" style="text-align:center; padding: 10px; color: green;">
            <?php
                if ($_GET['status'] == 'approved') {
                    echo 'Payment approved successfully!';
                } elseif ($_GET['status'] == 'rejected') {
                    echo 'Payment rejected successfully!';
                } elseif ($_GET['status'] == 'error') {
                    echo 'An error occurred while processing the payment.';
                }
            ?>
        </div>
    <?php endif; ?>

    <!-- Date Filter Form -->
    <form method="GET" action="admin_transactions.php">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">

        <button type="submit">Filter</button>
    </form>

    <table>
        <tr>
            <th>Transaction ID</th>
            <th>Student ID</th>
            <th>Amount</th>
            <th>Phone Number</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['transaction_id']) ?></td>
                <td><?= htmlspecialchars($row['user_id']) ?></td>
                <td>Kshs<?= number_format($row['amount'], 2) ?></td>
                <td><?= htmlspecialchars($row['phone_number']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= htmlspecialchars($row['date']) ?></td>
                <td>
                    <?php if ($row['status'] !== 'Completed'): ?>
                        <!-- If the payment is not completed, show the approve/reject options -->
                        <?php if (!empty($row['penalty_id'])): ?>
                            <a href="approve_payment.php?penalty_id=<?= $row['penalty_id'] ?>&action=approve" style="color:green;">Approve</a> | 
                            <a href="approve_payment.php?penalty_id=<?= $row['penalty_id'] ?>&action=reject" style="color:red;">Reject</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- If the payment is completed, hide the action column -->
                        Done
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="total-revenue">
        Total Revenue: Kshs <?= number_format($total_revenue, 2) ?>
    </div>

    <!-- Print Button -->
    <button class="print-button" onclick="window.print()">Print Transaction History</button>

    <!-- Return to Dashboard Button -->
    <a href="admin_dashboard.php">
        <button class="return-button">Return to Dashboard</button>
    </a>

</body>
</html>
