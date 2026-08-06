<?php

echo "HOST: " . getenv("MYSQLHOST") . "<br>";
echo "USER: " . getenv("MYSQLUSER") . "<br>";
echo "DB: " . getenv("MYSQLDATABASE") . "<br>";
echo "PORT: " . getenv("MYSQLPORT") . "<br>";

$conn = mysqli_connect(
    getenv("MYSQLHOST"),
    getenv("MYSQLUSER"),
    getenv("MYSQLPASSWORD"),
    getenv("MYSQLDATABASE"),
    getenv("MYSQLPORT")
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Database Connected Successfully";
?>