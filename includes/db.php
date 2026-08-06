<?php

$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$db = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $db,
    $port
);

if(!$conn){
    die("Database Connection Failed: ".mysqli_connect_error());
}

?>