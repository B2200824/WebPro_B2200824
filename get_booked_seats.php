<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cinema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT seat_number FROM seat_bookings WHERE status = 'occupied'";
$result = $conn->query($sql);

$occupiedSeats = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $occupiedSeats[] = $row['seat_number'];
    }
}

$conn->close();

echo json_encode($occupiedSeats);
?>
