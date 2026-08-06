
<?php

$host = getenv("altaria.proxy.rlwy.net:54935");
$user = getenv("root");
$password = getenv("EtlfKutXgOyqKGmngHwDRhVfRZVBFEuQ");
$database = getenv("railway");
$port = getenv("54935");

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database,
    $port
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>