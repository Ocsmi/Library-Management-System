<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Library</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="main-header">
        <div class="logo">📚 Tumaini College Library</div>
        <nav class="navbar">
            <a href="index.php" class="active">Home</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact Us</a>
            <a href="books.php">Books</a>
            <a href="search_books.php">Search Books</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Tumaini College Library</h1>
            <p>Explore a world of knowledge, right at your fingertips. Find, borrow, and discover books that elevate your learning experience.</p>
            <a href="books.php" class="btn">📖 Browse Books</a>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 College Library. All rights reserved.</p>
    </footer>
</body>
</html>
