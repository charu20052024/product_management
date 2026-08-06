<?php

$conn = mysqli_connect(
    "mysql-production-18ee.up.railway.app",
    "root",
    "EtlfKutXgOyqKGmngHwDRhVfRZVBFEuQ",
    "railway",
    33060
);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

echo "Database Connected";

?>