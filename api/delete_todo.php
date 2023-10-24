<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"),true);
    
    $itemId = $data['id'];
    
    // Include the database connection code (db.php)
    include '../include/db.php';
    // Perform the deletion operation and update the database
    $query = "DELETE FROM todo_items WHERE item_id = $itemId";
    $result = $conn->query($query);

    // To inform the client (browser) that the response contains JSON data
    header('Content-Type: application/json');

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Deletion failed']);
    }
}
