<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "laundry_db");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['rush'])) {
  $rushValue = $_GET['rush'];

  $stmt = mysqli_prepare($conn, "SELECT price FROM service_option_price WHERE service_option_type = ?");
  if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
  }
  mysqli_stmt_bind_param($stmt, "s", $rushValue);
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

  mysqli_stmt_close($stmt); // Close the prepared statement
} else {
  echo json_encode(['error' => 1, 'message' => 'Rush value not provided']);
}

mysqli_close($conn);
?>
