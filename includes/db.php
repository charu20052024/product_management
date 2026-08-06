<?php

$conn = mysqli_init();

mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

mysqli_real_connect(
    $conn,
    "mysql-production-18ee.up.railway.app",
    "root",
    "EtlfKutXgOyqKGmngHwDRhVfRZVBFEuQ",
    "railway",
    33060,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

echo "Database Connected";

?>