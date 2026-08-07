<?php

require_once "../includes/db.php";


$id=$_POST['id'];



$stmt=mysqli_prepare(

$conn,

"DELETE FROM products WHERE id=?"

);



mysqli_stmt_bind_param(

$stmt,

"i",

$id

);



if(mysqli_stmt_execute($stmt)){


echo "success";


}else{


echo "error";


}


?>