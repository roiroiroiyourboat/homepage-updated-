<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "laundry_db");

// Check connection
if (!$conn) {
  die("Connection failed: ". mysqli_connect_error());
}

// Check if service and category IDs are set
if (isset($_GET['service_id']) && isset($_GET['category_id'])) {
  $serviceId = $_GET['service_id'];
  $categoryId = $_GET['category_id'];

  // Prepare the query with parameterized values
  $stmt = mysqli_prepare($conn, "SELECT price FROM service_category_price WHERE service_id =? AND category_id =?");
  mysqli_stmt_bind_param($stmt, "ii", $serviceId, $categoryId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Check if a row was found
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $price = $row['price'];
    echo json_encode(['price' => $price, 'error' => 0]);
  } else {
    echo json_encode(['error' => 1, 'message' => 'Price not found']);
  }
} else {
  echo json_encode(['error' => 1, 'message' => 'Service or category ID not provided']);
}

// Close the database connection
mysqli_close($conn);
?>