<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $itemId = $data['id'];
    $newDescription = $data['description'];

    // Include the database connection code (db.php)
    include '../include/db.php';

    // Perform the edit operation and update the database
    $sql = "UPDATE todo_items SET description = ? WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newDescription, $itemId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Edit failed']);
    }
}
