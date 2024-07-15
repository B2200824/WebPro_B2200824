<?php
header('Content-Type: application/json');

// Get the raw POST data
$data = file_get_contents('php://input');

// Decode the JSON data
$orderDetails = json_decode($data, true);

$response = array();

// Validate order details
if (!isset($orderDetails['popcorn']) || !isset($orderDetails['soda']) || !isset($orderDetails['nachos'])) {
    $response['success'] = false;
    $response['message'] = 'Invalid order details.';
    echo json_encode($response);
    exit();
}

// Get quantities
$popcornQuantity = intval($orderDetails['popcorn']);
$sodaQuantity = intval($orderDetails['soda']);
$nachosQuantity = intval($orderDetails['nachos']);

// Calculate total cost
$popcornPrice = 5.00;
$sodaPrice = 3.00;
$nachosPrice = 4.50;

$totalCost = ($popcornQuantity * $popcornPrice) + ($sodaQuantity * $sodaPrice) + ($nachosQuantity * $nachosPrice);

// Assuming you are storing orders in a database, you would connect to your database here
// For the purpose of this example, we'll simulate a successful order placement

// Connect to the database
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "cinema"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $response['success'] = false;
    $response['message'] = 'Database connection failed.';
    echo json_encode($response);
    exit();
}

// Insert order into database
$sql = "INSERT INTO orders (popcorn_quantity, soda_quantity, nachos_quantity, total_cost)
        VALUES ($popcornQuantity, $sodaQuantity, $nachosQuantity, $totalCost)";

if ($conn->query($sql) === TRUE) {
    $response['success'] = true;
    $response['message'] = 'Order placed successfully.';
} else {
    $response['success'] = false;
    $response['message'] = 'Error placing order: ' . $conn->error;
}

$conn->close();

echo json_encode($response);
?>