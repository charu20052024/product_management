<?php
$conn = new mysqli(
    "altaria.proxy.rlwy.net",
    "root",
    "EtlfKutXgOyqKGmngHwDRhVfRZVBFEuQ",
    "railway",
    54935
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Database connected successfully!";
?>