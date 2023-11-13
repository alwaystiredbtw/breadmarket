<?php
$host = '127.0.0.1:3306';
$db = 'breadMarket';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    var_dump($conn->connect_error);
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>