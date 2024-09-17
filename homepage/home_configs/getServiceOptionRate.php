<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "laundry_db");

// Check connection
if (!$conn) {
  die("Connection failed: ". mysqli_connect_error());
}

if (isset($_GET['option_id'])) {
  $serviceOptionId = $_GET['option_id'];

  $stmt = mysqli_prepare($conn, "SELECT price FROM service_option_price WHERE option_id =?");
  mysqli_stmt_bind_param($stmt, "i", $serviceOptionId);
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

mysqli_close($conn);
?>