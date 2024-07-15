<?php
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cinema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $comment = $_POST['comment'] ?? null;

    // Log input values for debugging
    error_log("Username: $username, Rating: $rating, Comment: $comment");

    if (!$username || !$rating || !$comment) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    if (!is_numeric($rating)) {
        echo json_encode(["status" => "error", "message" => "Rating must be a number."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO comments3 (username, rating, comment) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("sis", $username, $rating, $comment);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
        error_log($stmt->error); // Log error to the server log for debugging
    }

    $stmt->close();
} else {
    // Fetch existing comments
    $result = $conn->query("SELECT username, rating, comment, timestamp FROM comments ORDER BY timestamp DESC");

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    echo json_encode($comments);
}

$conn->close();
?>