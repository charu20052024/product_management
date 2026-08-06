<?php
$conn = mysqli_connect(
    "your-host",
    "your-username",
    "your-password",
    "your-database",
    3306
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>