<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $customerId = $_POST['customer_id'] ?? null;
    $customerName = $_POST['customer_name'] ?? null;
    $serviceId = $_POST['serviceId'] ?? null;
    $serviceOptionName = $_POST['service_option'] ?? null;
    $isRush = $_POST['is_rush'];
    $address = $_POST['address'] ?? null;
    $pickupDate = date('Y-m-d', strtotime($_POST['pickup_date'] ?? null));
    $totalAmount = $_POST['total_amount'] ?? null;
    $deliveryFee = $_POST['delivery_fee'] ?? null;
    $rushFee = $_POST['rush_fee'] ?? null;
    $amountTendered = $_POST['amount_tendered'] ?? null;
    $change = $_POST['change'] ?? null;
    $laundryServiceID = $_POST['laundry_service_id'] ?? null;
    $laundryServiceOp = $_POST['laundry_service_op'] ?? null;
    $laundryCategoryID = $_POST['laundry_category_id'] ?? null;
    $laundryCategoryOp = $_POST['laundry_category_op'] ?? null;
    $laundryPrice = $_POST['laundry_price'] ?? null;
    $laundryWeight = $_POST['laundry_weight'] ?? null;

    $conn = new mysqli('localhost', 'root', '', 'laundry_db');

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit;
    }

    // Update customer address in tbl_customer
    $sqlUpdateCustomer = "UPDATE customer SET address = ? WHERE customer_id = ?";
    $stmtUpdateCustomer = $conn->prepare($sqlUpdateCustomer);
    $stmtUpdateCustomer->bind_param('si', $address, $customerId);

    if (!$stmtUpdateCustomer->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update customer address: ' . $stmtUpdateCustomer->error]);
        $stmtUpdateCustomer->close();
        $conn->close();
        exit;
    }
    $stmtUpdateCustomer->close();

    // Get active request_ids for the customer
    $sqlRequest = "SELECT request_id FROM service_request WHERE customer_id =? AND order_status NOT IN ('completed', 'cancelled')";
    $stmtRequest = $conn->prepare($sqlRequest);
    $stmtRequest->bind_param('i', $customerId);
    $stmtRequest->execute();
    $stmtRequest->store_result();
    $stmtRequest->bind_result($requestId);

    $requestIds = [];
    while ($stmtRequest->fetch()) {
        $requestIds[] = $requestId;
    }
    $stmtRequest->close();

    if (empty($requestIds)) {
        echo json_encode(['status' => 'error', 'message' => 'No active service request found for customer']);
        $conn->close();
        exit;
    }

    // Start transaction
    $conn->autocommit(false);

    // Process each active request_id
    foreach ($requestIds as $requestId) {
        // Insert transaction details into tbl_transaction
        $sqlTransaction = "INSERT INTO transaction (request_id, customer_id, customer_name, service_id, laundry_service_option, category_id, laundry_category_option, price, service_option_id, service_option_name, weight, laundry_cycle, customer_address, total_amount, delivery_fee, rush_fee, amount_tendered, money_change)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtTransaction = $conn->prepare($sqlTransaction);
        $stmtTransaction->bind_param('iisisisdisdssddddd', $requestId, $customerId, $customerName, $laundryServiceID, $laundryServiceOp, $laundryCategoryID, $laundryCategoryOp, $laundryPrice, $serviceId, $serviceOptionName, $laundryWeight, $isRush, $address, $totalAmount, $deliveryFee, $rushFee, $amountTendered, $change);

        if (!$stmtTransaction->execute()) {
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to save transaction details: ' . $stmtTransaction->error]);
            $stmtTransaction->close();
            $conn->close();
            exit;
        }
        $stmtTransaction->close();

        // Update pick up/delivery date in tbl_service_request
        $sqlPickUpDate = "UPDATE service_request SET request_date = ? WHERE request_id = ?";
        $stmtPickUpDate = $conn->prepare($sqlPickUpDate);
        $stmtPickUpDate->bind_param('si', $pickupDate, $requestId);

        if (!$stmtPickUpDate->execute()) {
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to update pickup date for request id ' . $requestId . ': ' . $stmtPickUpDate->error]);
            $stmtPickUpDate->close();
            $conn->close();
            exit;
        }
        $stmtPickUpDate->close();
        
        //update request_date in transaction
        $sqlUpdateTransactionDate = "UPDATE transaction SET request_date = ? WHERE request_id = ?";
        $stmtUpdateTransactionDate = $conn->prepare($sqlUpdateTransactionDate);
        $stmtUpdateTransactionDate->bind_param('si', $pickupDate, $requestId);

        if (!$stmtUpdateTransactionDate->execute()) {
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to update request date in transaction for request id ' . $requestId . ': ' . $stmtUpdateTransactionDate->error]);
            $stmtUpdateTransactionDate->close();
            $conn->close();
            exit;
        }
        $stmtUpdateTransactionDate->close();

        // Update order status to 'completed' in service_request table
        $sqlUpdate = "UPDATE service_request SET order_status = 'completed' WHERE request_id = ? AND customer_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param('ii', $requestId, $customerId);

        if (!$stmtUpdate->execute()) {
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to update order status to completed for request id ' . $requestId . ': ' . $stmtUpdate->error]);
            $stmtUpdate->close();
            $conn->close();
            exit;
        }
        $stmtUpdate->close();

        //update order status to 'completed' in transaction table
        $sqlUpdateTransaction = "UPDATE transaction SET order_status = 'completed' WHERE request_id = ? AND customer_id = ?";
        $stmtUpdateTransaction = $conn->prepare($sqlUpdateTransaction);
        $stmtUpdateTransaction->bind_param('ii', $requestId, $customerId);

        if (!$stmtUpdateTransaction->execute()) {
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to update order status to completed for request id ' . $requestId . ' in transaction table: ' . $stmtUpdateTransaction->error]);
            $stmtUpdateTransaction->close();
            $conn->close();
            exit;
        }
        $stmtUpdateTransaction->close();
    }

    // Commit transaction
    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'Your service details saved successfully.']);

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
