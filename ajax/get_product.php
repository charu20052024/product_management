<?php

require_once "../includes/db.php";


$id=$_GET['id'];



$stmt=mysqli_prepare(

$conn,

"SELECT * FROM products WHERE id=?"

);



mysqli_stmt_bind_param(

$stmt,

"i",

$id

);



mysqli_stmt_execute($stmt);



$result=mysqli_stmt_get_result($stmt);



$data=mysqli_fetch_assoc($result);



echo json_encode($data);


?>