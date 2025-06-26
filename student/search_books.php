<?php
include('connect_db.php');

if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "
        SELECT book_id, title, author FROM tblbooks
        WHERE book_id NOT IN (
            SELECT book_id FROM tblborrow
            WHERE status IN ('pending', 'approved')
        ) AND title LIKE '$search%'
    ";
    $result = $conn->query($sql);

    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($books);
}
?>