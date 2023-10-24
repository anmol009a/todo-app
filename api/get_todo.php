<?php
// Include the database connection code (db.php)
include '../include/db.php';

// get username
session_start();
// Fetch and return To-Do items from the database
$query = "SELECT * FROM todo_items WHERE user_id = " . $_SESSION['user_id'];
$result = $conn->query($query);

// To inform the client (browser) that the response contains JSON data
header('Content-Type: application/json');

if ($result) {
    $items = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($items);
} else {
    echo json_encode([]);
}
