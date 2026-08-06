<?php

$conn = mysqli_connect(
    "mysql-production-55b5.up.railway.app", // Railway public host
    "root",                                 // MySQL username
    "EtlfKutXgOyqKGmngHwDRhVfRZVBFEuQ",                  // MySQL password
    "railway",                              // Database name
    3307                                    // MySQL port
);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>