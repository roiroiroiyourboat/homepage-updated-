<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'laundry_db');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

//retrive username from input
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';

//sql query
$query = "SELECT question FROM users WHERE username = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $username); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo json_encode(['success' => true, 'question' => $row['question']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found or no question set']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement']);
}

$conn->close();
?>
