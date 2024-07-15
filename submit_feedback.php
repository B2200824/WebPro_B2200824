<?php
$servername = "localhost";
$username = "root";  // replace with your database username
$password = "";      // replace with your database password
$dbname = "red_cinema_feedback";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$booking_experience = $_POST['booking_experience'];
$cinema_experience = $_POST['cinema_experience'];
$food_beverage = $_POST['food_beverage'];
$staff = $_POST['staff'];
$comments = $_POST['comments'];

$sql = "INSERT INTO feedback (name, email, booking_experience, cinema_experience, food_beverage, staff, comments)
VALUES ('$name', '$email', '$booking_experience', '$cinema_experience', '$food_beverage', '$staff', '$comments')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
