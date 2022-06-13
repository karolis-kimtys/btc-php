<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['SQL_HOST'];
$username = $_ENV['SQL_USER'];
$password = $_ENV['SQL_PASSWORD'];
$database = $_ENV['SQL_DB'];

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die('Could not Connect MySql Server:' . mysqli_connect_error());
}

?>