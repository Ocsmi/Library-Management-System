<?php
session_start();
include('connect_db.php');
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Check if a book ID is provided for deletion
if (isset($_GET['delete_book_id'])) {
    $book_id = intval($_GET['delete_book_id']);

    // Delete all borrow records associated with the book
    $conn->query("DELETE FROM tblborrow WHERE book_id = $book_id");

    // Delete the book from the books table
    $conn->query("DELETE FROM tblbooks WHERE book_id = $book_id");

    // Redirect back to manage_books.php with a success message
    header('Location: manage_books.php?message=Book+Deleted+Successfully');
    exit;
}

// Fetch books
$books = $conn->query("SELECT * FROM tblbooks");

// Add book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];

    $sql = "INSERT INTO tblbooks (title, author, genre) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $title, $author, $genre);
    $stmt->execute();
    header('Location: manage_books.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Manage Books</title>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_books.php">Manage Books</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="approve_borrow.php">Approve Borrow Requests</a></li>
                    <li><a href="return_books.php">Manage Returns</a></li>
                    <li><a href="borrowed_books.php">View Borrowed Books</a></li>

                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <h1>Manage Books</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </header>

            <!-- Add Book Form -->
            <section class="add-book-form">
                <h2>Add New Book</h2>
                <form method="POST">
                    <input type="text" name="title" placeholder="Title" required>
                    <input type="text" name="author" placeholder="Author" required>
                    <input type="text" name="genre" placeholder="Genre" required>
                    <button type="submit" name="add_book">Add Book</button>
                </form>
            </section>

            <!-- Books List -->
            <section class="books-list">
                <h2>Books List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($book = $books->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $book['title'] ?></td>
                                <td><?= $book['author'] ?></td>
                                <td><?= $book['genre'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <footer>
        <p>&copy; 2025 College Library. All rights reserved.</p>
    </footer>
</body>
</html>
