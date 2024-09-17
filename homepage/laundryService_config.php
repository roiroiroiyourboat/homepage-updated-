<?php
session_start();
header('Content-Type: application/json');

try {
    $orders = json_decode($_POST['orders'], true);

    $conn = new mysqli('localhost', 'root', '', 'laundry_db');

    if ($conn->connect_error) {
        throw new Exception('Connection Failed: ' . $conn->connect_error);
    } else {
        $service_request_id = null;
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

            // Insert order
            $stmt = $conn->prepare("INSERT INTO service_request (customer_id, customer_name, contact_number, service_id, laundry_service_option, category_id, laundry_category_option, quantity, weight, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issisisidd", $customer_id, $customer_name, $contact_number, $service_id, $service_option, $category_id, $category_option, $quantity, $weight, $price);
            $stmt->execute();
            $service_request_id = $conn->insert_id;
            $stmt->close();
        }

        $conn->close();

        $response = array(
            'status' => 'success',
            'message' => 'Your order has been saved successfully.',
            'customer_id' => $customer_id,
            'service_request_id' => $service_request_id,
            'customer_name' => $customer_name,
            'contact_number' => $contact_number,
            'service_id' => $service_id,
            'service_option' => $service_option,
            'category_id' => $category_id,
            'category_option' => $category_option,
            'weight' => $weight,
            'price' => $price
            
        );

        echo json_encode($response);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>