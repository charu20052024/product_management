<?php

$host = "altaria.proxy.rlwy.net";
$user = "root";
$password = "EtlfKutXgOyqKGmngHwDRhVfRZVBFEuQ";
$database = "railway";
$port = 54935;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

echo "Database Connected";

?>