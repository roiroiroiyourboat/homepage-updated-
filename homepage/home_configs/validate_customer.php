<?php
session_start();
header('Content-Type: application/json');

try {
    $customer_name = $_POST['customer_name'];
    $contact_number = $_POST['contact_number'];

    $conn = new mysqli('localhost', 'root', '', 'laundry_db');

    if ($conn->connect_error) {
        throw new Exception('Connection Failed: ' . $conn->connect_error);
    } else {
        // Check if the customer with the same name and contact number exists
        $stmt = $conn->prepare("SELECT customer_id FROM customer WHERE customer_name = ? AND contact_number = ?");
        $stmt->bind_param("ss", $customer_name, $contact_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
           // return customer id if the customer name and contact number exist
            $row = $result->fetch_assoc();
            echo json_encode(['status' => 'success', 'customer_id' => $row['customer_id']]);
        } else {
            //check if the contact number is already exist
            $stmt = $conn->prepare("SELECT customer_id, customer_name FROM customer WHERE contact_number = ?");
            $stmt->bind_param("s", $contact_number);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (strcasecmp($row['customer_name'], $customer_name) === 0) {
                    echo json_encode(['status' => 'success', 'customer_id' => $row['customer_id']]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Contact number already exists.']);
                }
            } else {
                // insert new customer
                $stmt = $conn->prepare("INSERT INTO customer (customer_name, contact_number) VALUES (?, ?)");
                $stmt->bind_param("ss", $customer_name, $contact_number);
                if ($stmt->execute()) {
                    $customer_id = $stmt->insert_id;
                    echo json_encode(['status' => 'success', 'customer_id' => $customer_id]);
                } else {
                    throw new Exception('Error inserting customer data');
                }
            }
        }
        $stmt->close();
    }
    $conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
