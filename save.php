<?php

include 'database.php';

$price = $_POST['price'];
$timestamp = $_POST['timestamp'];
$date = $_POST['date'];
$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];
$hour = $_POST['hour'];
$zerohour = $_POST['zerohour'];

$sql = "INSERT INTO data (price, timestamp, date, year, month, day, hour, zerohour) 
	VALUES ('$price', '$timestamp', '$date', '$year', '$month', '$day', '$hour', '$zerohour')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['statusCode' => 200]);
} else {
    echo json_encode(['statusCode' => 201]);
}

mysqli_close($conn);
?>