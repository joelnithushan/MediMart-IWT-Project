<?php

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "medimart_db";//db name

//create connection
$conn = new mysqli($serverName, $userName, $password, $dbName);

//check connection
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

?>