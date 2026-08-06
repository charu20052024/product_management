<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    $conn = mysqli_connect(
        "mysql-production-18ee.up.railway.app:33060",  // Railway public host
        "root",                                  // MySQL username
        "EtlfKutXgOyqKGmngHwDRhVfRZVBFEuQ",                     // Railway MySQL password
        "railway",                               // Database name
        33060                                    // Railway public port
    );

    echo "Database Connected";

} catch (mysqli_sql_exception $e) {

    die("Database Connection Failed: " . $e->getMessage());

}

?>