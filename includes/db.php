<?php

$conn = mysqli_connect(
    "mysql.railway.internal",
    "root",
    "dVoxYtVgCwQmvlfnAxaExKhdMtEKkRMh",
    "railway",
    3306
);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>