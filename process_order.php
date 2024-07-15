<?php
// process_order.php

// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "cinema_orders"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission if POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to insert order into orders table
    function insertOrder($conn, $itemName, $quantity, $price) {
        $stmt = $conn->prepare("INSERT INTO orders (item_name, quantity, price) VALUES (?, ?, ?)");
        $stmt->bind_param("sid", $itemName, $quantity, $price);
        $stmt->execute();
        $stmt->close();
    }

    // Calculate total price and prepare message
    $popcornQuantity = $_POST['popcorn-quantity'];
    $sodaQuantity = $_POST['soda-quantity'];
    $nachosQuantity = $_POST['nachos-quantity'];

    // Calculate total price
    $totalPrice = (5.00 * $popcornQuantity) + (3.00 * $sodaQuantity) + (4.50 * $nachosQuantity);

    // Insert order into database
    insertOrder($conn, "Popcorn", $popcornQuantity, 5.00 * $popcornQuantity);
    insertOrder($conn, "Soda", $sodaQuantity, 3.00 * $sodaQuantity);
    insertOrder($conn, "Nachos", $nachosQuantity, 4.50 * $nachosQuantity);

    // Close connection
    $conn->close();

    // Prepare message to display quantities in alert
    $message = "Popcorn: $popcornQuantity, Soda: $sodaQuantity, Nachos: $nachosQuantity";

    // Output JavaScript to alert and redirect
    echo '<script>
            alert("Order placed successfully! Quantities: ' . $message . ' Total Price: RM' . number_format($totalPrice, 2) . '");
            window.location.href = "qrpayment.html";
          </script>';
    exit; // Ensure script execution stops here
}

// Close connection (if not already closed due to early exit)
$conn->close();
?>



