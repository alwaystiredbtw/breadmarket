<?php
$host = '127.0.0.1:3306';
$db = 'breadMarket';
$user = 'root';
$password = 'admin';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    var_dump($conn->connect_error);
}

session_start();

?>