<?php  
include('connect_db.php');
session_start();

// Fetch available books, including publisher, ISBN, and edition
$books = $conn->query("SELECT * FROM tblbooks WHERE status = 'available'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Books | Tumaini College Library</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        header {
            background-color: #003366;
            padding: 20px 0;
            text-align: center;
        }

        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .books-section {
            max-width: 1100px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .books-section h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
            color: #003366;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead {
            background-color: #003366;
            color: white;
        }

        table th, table td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table tbody tr:hover {
            background-color: #f0f8ff;
        }

        .borrow-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            text-align: center;
        }

        .borrow-btn:hover {
            background-color: #0056b3;
        }

        .login-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            text-align: center;
        }

        .login-btn:hover {
            background-color: #218838;
        }

        footer {
            background-color: #003366;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact Us</a>
            <a href="books.php">Books</a>
            <a href="search_books.php">Search Books</a>
        </nav>
    </header>

    <section class="books-section">
        <h1>📚 Available Books</h1>
        <table>
            <thead>
                <tr>
                    <th>📖 Title</th>
                    <th>✍️ Author</th>
                    <th>📂 Category</th>
                    <th>📚 Publisher</th>
                    <th>📘 ISBN</th>
                    <th>📙 Edition</th>
                    <th>🔗 Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($books->num_rows > 0): ?>
                    <?php while ($book = $books->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['genre']) ?></td>
                            <td><?= htmlspecialchars($book['Publisher']) ?></td>
                            <td><?= htmlspecialchars($book['ISBN']) ?></td>
                            <td><?= htmlspecialchars($book['edition']) ?></td>
                            <td>
                                <?php if (!isset($_SESSION['user_id'])): ?>
                                    <a class="login-btn" href="student/login.php">Login to Borrow</a>
                                <?php else: ?>
                                    <a class="borrow-btn" href="borrow_book.php?book_id=<?= $book['book_id'] ?>">Borrow</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; color: #999;">No books available at the moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2025 College Library. All rights reserved.</p>
    </footer>

</body>
</html>
