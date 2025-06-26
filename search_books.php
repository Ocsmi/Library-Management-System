<?php
include('connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_query = $_POST['search_query'];
    $sql = "SELECT * FROM tblbooks WHERE title LIKE ? OR author LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search_query . "%";
    $stmt->bind_param('ss', $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books | College Library</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
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

        .search-section {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .search-section h1 {
            text-align: center;
            font-size: 32px;
            color: #003366;
            margin-bottom: 25px;
        }

        form {
            text-align: center;
            margin-bottom: 30px;
        }

        form input[type="text"] {
            width: 60%;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 10px;
        }

        form button:hover {
            background-color: #005599;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #003366;
            color: white;
        }

        .no-result {
            text-align: center;
            color: #888;
            font-size: 18px;
        }

        footer {
            background-color: #003366;
            color: white;
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

    <section class="search-section">
        <h1>🔍 Search Books</h1>
        <form method="POST">
            <input type="text" name="search_query" placeholder="Search by title or author" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($book = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['genre'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php elseif ($result): ?>
            <p class="no-result">No books found matching your search.</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 College Library. All rights reserved.</p>
    </footer>

</body>
</html>
