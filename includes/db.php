
<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "DB START<br>";

$conn = mysqli_connect(
    "mysql-production-18ee.up.railway.app",
    "root",
    "EtlfKutXgOyqKGmngHwDRhVfRZVBFEuQ",
    "railway",
    33060
);

echo "DB CONNECTED";

?>