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
	VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo 'SQL statement failed';
} else {
    mysqli_stmt_bind_param(
        $stmt,
        'ssssssss',
        $price,
        $timestamp,
        $date,
        $year,
        $month,
        $day,
        $hour,
        $zerohour
    );
}

if (mysqli_query($conn, $sql)) {
    echo json_encode(['statusCode' => 200]);
} else {
    echo json_encode(['statusCode' => 201]);
}

mysqli_close($conn);
?>