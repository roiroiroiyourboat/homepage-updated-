<?php
session_start();
header('Content-Type: application/json');

//connect to the database
$conn = new mysqli('localhost', 'root', '', 'laundry_db');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

//to get the json input
$input = file_get_contents('php://input');
$data = json_decode($input, true);


//to check if the username and answer are provided
if (isset($data['reset_pass_username']) && !empty($data['reset_pass_username']) && isset($data['answer']) && !empty($data['answer'])) {
    $username = $data['reset_pass_username'];
    $answer = $data['answer'];

    //to check if the username exists in the database
    $query = $conn->prepare("SELECT answer FROM users WHERE BINARY username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        //to verify the answer from the database that is hashed
        if (password_verify($answer, $user['answer'])) {
            $_SESSION['verified_user'] = $username;
            echo json_encode(['success' => true, 'message' => 'Proceed to password reset.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect Answer.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Username not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Username or Answer not provided.']);
}

$conn->close();
?>
