
<?php
$conn = mysqli_connect(
    getenv("mysql.railway.internal"),
    getenv("root"),
    getenv("VoxYtVgCwQmvlfnAxaExKhdMtEKkRMh"),
    getenv("product_management"),
    getenv("3306")
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>