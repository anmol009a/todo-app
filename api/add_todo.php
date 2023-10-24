<?php
// Handle the POST request and retrieve the to-do item description
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $description = $data->description;

    // Get user ID from the session or user authentication
    session_start();
    $user_id = $_SESSION['user_id'];

    // Include the database connection code (db.php)
    include '../include/db.php';
    
    // Insert the to-do item into the database
    $sql = "INSERT INTO todo_items (user_id, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $description);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    // Return an error response for unsupported request methods
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
