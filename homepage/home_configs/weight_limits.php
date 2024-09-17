<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root','','laundry_db');

    if(!$conn){
        die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]));
    }

$response = array();

try {
    $query = "SELECT min_kilos, max_kilos FROM settings WHERE setting_id = 1"; 
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response['status'] = 'success';
        $response['minWeight'] = $row['min_kilos'];
        $response['maxWeight'] = $row['max_kilos'];
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Weight limits not found';
    }
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'An error occurred while fetching weight limits: ' . $e->getMessage();
}

echo json_encode($response);

mysqli_close($conn);
?>
