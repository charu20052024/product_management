<?php

require_once "../includes/db.php";


$id=$_POST['id'];


$product_name=$_POST['product_name'];

$product_code=$_POST['product_code'];

$category=$_POST['category'];

$brand=$_POST['brand'];

$purchase_price=$_POST['purchase_price'];

$selling_price=$_POST['selling_price'];

$quantity=$_POST['quantity'];

$unit=$_POST['unit'];

$description=$_POST['description'];





$stmt=mysqli_prepare(

$conn,

"UPDATE products SET


product_name=?,

product_code=?,

category=?,

brand=?,

purchase_price=?,

selling_price=?,

quantity=?,

unit=?,

description=?


WHERE id=?

"

);




mysqli_stmt_bind_param(

$stmt,

"ssssddissi",

$product_name,

$product_code,

$category,

$brand,

$purchase_price,

$selling_price,

$quantity,

$unit,

$description,

$id

);



if(mysqli_stmt_execute($stmt)){


echo "success";


}else{


echo "error";


}



?>