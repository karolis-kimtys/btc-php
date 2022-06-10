<?php
header('Content-Type:application/json');

// Check only "year" parameter present in URL
// http://localhost:8888/btc/api.php?year=2022
if (
    isset($_GET['year']) &&
    empty($_GET['month']) &&
    empty($_GET['day']) &&
    empty($_GET['hour']) &&
    $_GET['year'] != ''
) {
    include 'database.php';
    $year = $_GET['year'];

    $query = 'SELECT * FROM data WHERE year = ' . $year;
    $result = mysqli_query($conn, $query);
    print_r($result);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        print_r($row);
        $year = isset($_GET['year']);

        response($year);
        mysqli_close($conn);
    } else {
        response(null, null, 200, 'No Record Found');
    }
} else {
    response(null, null, 400, 'Invalid Request');
}

// Check if "year" and "month" parameters present in URL
// http://localhost:8888/btc/api.php?year=2022&month=6
if (
    isset($_GET['year']) &&
    isset($_GET['month']) &&
    empty($_GET['day']) &&
    empty($_GET['hour']) &&
    $_GET['year'] != '' &&
    $_GET['month'] != ''
) {
    include 'database.php';
    $year = $_GET['year'];
    $month = $_GET['month'];

    $query =
        'SELECT * FROM data WHERE year = ' . $year . ' AND month = ' . $month;
    $result = mysqli_query($conn, $query);
    print_r($result);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        print_r($row);
        $year = isset($_GET['year']);
        $month = isset($_GET['month']);
        response($year, $month);
        mysqli_close($conn);
    } else {
        response(null, null, 200, 'No Record Found');
    }
} else {
    response(null, null, 400, 'Invalid Request');
}

// Check if "year" and "month" and "day" parameters present in URL
// http://localhost:8888/btc/api.php?year=2022&month=6&day=9
if (
    isset($_GET['year']) &&
    isset($_GET['month']) &&
    isset($_GET['day']) &&
    empty($_GET['hour']) &&
    $_GET['year'] != '' &&
    $_GET['month'] != '' &&
    $_GET['day'] != ''
) {
    include 'database.php';
    $year = $_GET['year'];
    $month = $_GET['month'];
    $day = $_GET['day'];
    $query =
        'SELECT * FROM data WHERE year = ' .
        $year .
        ' AND month = ' .
        $month .
        ' AND day = ' .
        $day;
    $result = mysqli_query($conn, $query);
    print_r($result);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        print_r($row);
        $year = isset($_GET['year']);
        $month = isset($_GET['month']);
        $day = isset($_GET['day']);
        response($year, $month, $day);
        mysqli_close($conn);
    } else {
        response(null, null, 200, 'No Record Found');
    }
} else {
    response(null, null, 400, 'Invalid Request');
}

// Check if "year" and "month" and "day" and "hour" parameters present in URL
// http://localhost:8888/btc/api.php?year=2022&month=6&day=9&hour=22
if (
    isset($_GET['year']) &&
    isset($_GET['month']) &&
    isset($_GET['day']) &&
    isset($_GET['hour']) &&
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

function response($year = '', $month = '', $day = '', $hour = '')
{
    $response['year'] = $year;
    $response['month'] = $month;
    $response['day'] = $day;
    $response['hour'] = $hour;

    $json_response = json_encode($response);
    echo $json_response;
}
?>