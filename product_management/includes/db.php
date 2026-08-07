<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "product_management";


$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);


if (!$conn) {

    die(
        "Database Connection Failed: " .
        mysqli_connect_error()
    );

}


// Set charset
mysqli_set_charset(
    $conn,
    "utf8mb4"
);

?>