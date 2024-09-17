<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $customerId = $_POST['customer_id']?? null;

    $conn = new mysqli('localhost', 'root', '', 'laundry_db');

    //check connection
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit;
    }

    // Retrieve all active service requests for the customer
    $sqlGetServiceRequests = "SELECT request_id FROM service_request WHERE customer_id =? AND order_status = 'active'";
    $stmtGetServiceRequests = $conn->prepare($sqlGetServiceRequests);
    $stmtGetServiceRequests->bind_param('i', $customerId);
    $stmtGetServiceRequests->execute();
    $result = $stmtGetServiceRequests->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $serviceRequestId = $row['request_id'];

            // Cancel service request
            $sqlCancelServiceRequest = "UPDATE service_request SET order_status = 'cancelled' WHERE request_id =?";
            $stmtCancelServiceRequest = $conn->prepare($sqlCancelServiceRequest);
            $stmtCancelServiceRequest->bind_param('i', $serviceRequestId);

            if (!$stmtCancelServiceRequest->execute()) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to cancel service request: '. $stmtCancelServiceRequest->error]);
                $stmtCancelServiceRequest->close();
                $conn->close();
                exit;
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'All active service requests for customer cancelled successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No active service requests found for customer']);
    }

    $stmtGetServiceRequests->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>