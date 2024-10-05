<?php
session_start();
header('Content-Type: application/json');

try {
    $orders = json_decode($_POST['orders'], true);
    $isNewTransaction = $_POST['isNewTransaction']; //check if it's new transaction

    $conn = new mysqli('localhost', 'root', '', 'laundry_db');
    
    if ($conn->connect_error) {
        throw new Exception('Connection Failed: ' . $conn->connect_error);
    } else {
       //checking if new transaction is starting
       if ($isNewTransaction == 'true' || !isset($_SESSION['customer_order_id'])) {
            //generate a new customer_order_id
            $_SESSION['customer_order_id'] = uniqid('ord_');
        }

        // Retrieve the current customer_order_id
        $customer_order_id = $_SESSION['customer_order_id'];

        foreach ($orders as $order) {
            $customer_name = $order['customerName'];
            $contact_number = $order['contactNumber'];
            $quantity = $order['quantity'];
            $service_id = $order['serviceId'];
            $service_option = $order['serviceOption'];
            $category_id = $order['categoryId'];
            $category_option = $order['categoryOption'];
            $weight = $order['weight'];
            $price = $order['price'];

            // Check if customer already exists
            $stmt = $conn->prepare("SELECT customer_id FROM customer WHERE customer_name = ?");
            $stmt->bind_param("s", $customer_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $customer_id = $row['customer_id'];
            } else {
                // Insert new customer
                $stmt = $conn->prepare("INSERT INTO customer (customer_name, contact_number) VALUES (?, ?)");
                $stmt->bind_param("si", $customer_name, $contact_number);
                $stmt->execute();
                $customer_id = $stmt->insert_id;
            }
            $stmt->close();

            // Insert order with customer_order_id
            $stmt = $conn->prepare("INSERT INTO service_request (customer_id, customer_name, contact_number, service_id, laundry_service_option, category_id, laundry_category_option, quantity, weight, price, customer_order_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issisisidds", $customer_id, $customer_name, $contact_number, $service_id, $service_option, $category_id, $category_option, $quantity, $weight, $price, $customer_order_id);
            $stmt->execute();
            $service_request_id = $conn->insert_id; // Get the latest service request ID
            $stmt->close();
        }

        $conn->close();

        $response = array(
            'status' => 'success',
            'message' => 'Your order has been saved successfully.',
            'customer_id' => $customer_id,
            'customer_order_id' => $customer_order_id, // Include the customer order ID in the response
            'service_request_id' => $service_request_id,
            'customer_name' => $customer_name,
            'contact_number' => $contact_number
        );

        echo json_encode($response);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
