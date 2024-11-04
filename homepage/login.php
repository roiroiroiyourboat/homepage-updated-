<?php
session_start();
header('Content-Type: application/json'); // Set the content type to JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $conn = new mysqli('localhost', 'root', '', 'laundry_db');

        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'title' => 'Connection Error', 'message' => 'Failed to connect to database.']);
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        if ($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();

            if (password_verify($password, $data['password'])) {
                $_SESSION['user_role'] = $data['user_role'];
                $_SESSION['username'] =  $data['username'];
                $_SESSION['user_id'] =  $data['user_id'];
                
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'title' => 'Mismatch password', 'message' => 'The password you entered is incorrect!']);
            }
        } else {
            echo json_encode(['success' => false, 'title' => 'Invalid username or password', 'message' => 'No user found with that username!']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'title' => 'Incomplete data', 'message' => 'Please enter both username and password!']);
    }
} else {
    echo json_encode(['success' => false, 'title' => 'Invalid access', 'message' => 'Please use the login form to access this page.']);
}
?>
