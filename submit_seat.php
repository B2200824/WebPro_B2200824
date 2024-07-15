<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cinema_booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedSeats = isset($_POST['seats']) ? explode(',', $_POST['seats']) : [];

    if (empty($selectedSeats)) {
        echo json_encode(['success' => false, 'message' => 'No seats selected.']);
        $conn->close();
        exit();
    }

    $success = true;
    $message = '';

    foreach ($selectedSeats as $seatIndex) {
        $seatNumber = intval($seatIndex) + 1;

        // Check if the seat is available
        $checkSql = "SELECT * FROM seats WHERE seat_number = $seatNumber AND status = 'available'";
        $result = $conn->query($checkSql);

        if ($result->num_rows > 0) {
            // Update seat status to occupied
            $updateSql = "UPDATE seats SET status = 'occupied' WHERE seat_number = $seatNumber";
            if ($conn->query($updateSql) !== TRUE) {
                $success = false;
                $message .= "Error updating seat $seatNumber. ";
            }
        } else {
            $success = false;
            $message .= "Seat $seatNumber is already occupied or does not exist. ";
        }
    }

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Seats booked successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to book seats. ' . $message]);
    }
}

$conn->close();
?>
