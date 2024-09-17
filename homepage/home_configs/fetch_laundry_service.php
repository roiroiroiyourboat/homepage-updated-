<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'laundry_db');
if ($conn->connect_error) {
    die(json_encode(['error' => 'Failed to connect: ' . $conn->connect_error]));
} else {
    $sql = "SELECT service_id, laundry_service_option FROM service";
    $result = $conn->query($sql);

    if (!$result) {
        die(json_encode(['error' => 'Failed to execute query: ' . $conn->error]));
    }

    $options = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[] = [
                'service_id' => $row['service_id'],
                'laundry_service_option' => $row['laundry_service_option']
            ];
        }
    }
    echo json_encode($options);
}

$conn->close();
?>
