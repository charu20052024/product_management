
<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = mysqli_connect(
    "mysql-production-18ee.up.railway.app",
    "root",
    "EtlfKutXgOyqKGmngHwDRhVfRZVBFEuQ",
    "railway",
    33060
);

echo "Database Connected";

?>