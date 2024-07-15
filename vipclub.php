<?php
session_start();

$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "cinema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['points-to-apply'])) {
    $pointsToApply = intval($_POST['points-to-apply']);
    $username = $_SESSION['username'];

    // Fetch the current points
    $sql = "SELECT points FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentPoints = intval($row['points']);

        if ($pointsToApply <= $currentPoints) {
            $newPoints = $currentPoints - $pointsToApply;

            // Update points in the database
            $sql = "UPDATE users SET points='$newPoints' WHERE username='$username'";
            if ($conn->query($sql) === TRUE) {
                $message = "Points successfully redeemed. You now have $newPoints points left.";
            } else {
                $message = "Error updating record: " . $conn->error;
            }
        } else {
            $message = "You do not have enough points to redeem.";
        }
    } else {
        $message = "User not found.";
    }
} else {
    $message = "No points specified for redemption.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Points</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Redeem Points</h1>
    </header>
    <div class="container">
        <div class="apply-points">
            <h3>Apply Points</h3>
            <form id="apply-points-form" method="POST" action="redeem_points.php">
                <label for="points-to-apply">Points to Apply:</label>
                <input type="number" id="points-to-apply" name="points-to-apply" min="0" max="1500">
                <button type="submit">Apply</button>
            </form>
            <p id="apply-message"><?= isset($message) ? $message : 'points applied'; ?></p>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Cinema Membership</p>
        <p>
            <a href="#">Terms of Service</a> | 
            <a href="#">Privacy Policy</a> | 
            <a href="#">FAQ</a>
        </p>
        <p>Contact: support@cinemamembership.com</p>
    </footer>
</body>
</html>
