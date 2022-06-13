<?php
header('Content-Type:application/json');

// URL
// http://localhost:8888/btc/api.php/2022/12/31/2259

include 'database.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));
$uri = array_filter($uri);
$uri = array_values($uri);

$year = null;
$month = null;
$day = null;
$hour = null;

if (isset($uri[2])) {
    $year = 'year = ' . $uri[2];
}
if (isset($uri[3])) {
    $month = 'AND month = ' . $uri[3];
}
if (isset($uri[4])) {
    $day = 'AND day = ' . $uri[4];
}
if (isset($uri[5])) {
    $hour = 'AND hour = ' . $uri[5];
}

$query = "SELECT * FROM data WHERE $year $month $day $hour";

$result = mysqli_query($conn, $query);
// print_r($result);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($row);
    mysqli_close($conn);
} else {
    echo 'No Record Found';
}
?>