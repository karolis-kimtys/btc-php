<?php
header('Content-Type:application/json');
if (
    isset($_GET['year'], $_GET['month'], $_GET['day'], $_GET['hour']) &&
    $_GET['year'] != '' &&
    $_GET['month'] != '' &&
    $_GET['day'] != '' &&
    $_GET['hour'] != ''
) {
    include 'database.php';
    $year = $_GET['year'];
    $month = $_GET['month'];
    $day = $_GET['day'];
    $hour = $_GET['hour'];
    $query =
        'SELECT * FROM data WHERE year = ' .
        $year .
        ' AND month = ' .
        $month .
        ' AND day = ' .
        $day .
        ' AND hour = ' .
        $hour;
    $result = mysqli_query($conn, $query);
    print_r($result);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        print_r($row);
        $year = isset($_GET['year']);
        $month = isset($_GET['month']);
        $day = isset($_GET['day']);
        $hour = isset($_GET['hour']);
        response($year, $month, $day, $hour);
        mysqli_close($conn);
    } else {
        response(null, null, 200, 'No Record Found');
    }
} else {
    response(null, null, 400, 'Invalid Request');
}

// http://localhost:8888/btc/api.php?year=2023&month=12&day=31&hour=23

function response($year, $month, $day, $hour)
{
    $response['year'] = $year;
    $response['month'] = $month;
    $response['day'] = $day;
    $response['hour'] = $hour;

    $json_response = json_encode($response);
    echo $json_response;
}
?>