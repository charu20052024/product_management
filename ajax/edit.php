<?php

require_once "../includes/db.php";


// CHECK ID

if(!isset($_GET["id"])){

    header("Location: ../index.php");
    exit();

}


$id = intval($_GET["id"]);



// FETCH PRODUCT


$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM products WHERE id=?"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);



if(mysqli_num_rows($result)==0){

    die("Product not found");

}



$product = mysqli_fetch_assoc($result);




// UPDATE PRODUCT


if(isset($_POST["update_product"])){


$product_name = trim($_POST["product_name"]);

$product_code = trim($_POST["product_code"]);

$category = trim($_POST["category"]);

$brand = trim($_POST["brand"]);

$purchase_price = $_POST["purchase_price"];

$selling_price = $_POST["selling_price"];

$quantity = $_POST["quantity"];

$unit = $_POST["unit"];

$description = trim($_POST["description"]);




// OLD IMAGE

$image = $product["image"];




// NEW IMAGE UPLOAD


if(isset($_FILES["image"]) && $_FILES["image"]["name"]!=""){


$image_name = time()."_".$_FILES["image"]["name"];


move_uploaded_file(
    $_FILES["image"]["tmp_name"],
    "../uploads/".$image_name
);


$image=$image_name;


}






$sql = "

UPDATE products SET

product_name=?,
product_code=?,
category=?,
brand=?,
purchase_price=?,
selling_price=?,
quantity=?,
unit=?,
description=?,
image=?

WHERE id=?

";



$update=mysqli_prepare(

$conn,

$sql

);



if(!$update){

die(
"SQL ERROR: ".mysqli_error($conn)
);

}




mysqli_stmt_bind_param(

$update,

"ssssddisssi",

$product_name,

$product_code,

$category,

$brand,

$purchase_price,

$selling_price,

$quantity,

$unit,

$description,

$image,

$id

);




mysqli_stmt_execute($update);



header("Location: ../index.php");

exit();


}



?>



<!DOCTYPE html>

<html>

<head>


<title>Edit Product</title>


<meta name="viewport" content="width=device-width, initial-scale=1">



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">



</head>



<body class="bg-light">



<div class="container mt-5">



<div class="card shadow p-4">



<h3 class="mb-4">

Edit Product

</h3>




<form method="POST" enctype="multipart/form-data">





<label>

Product Name

</label>


<input

type="text"

name="product_name"

class="form-control mb-3"

value="<?=htmlspecialchars($product['product_name']);?>"

required>





<label>

Product Code

</label>


<input

type="text"

name="product_code"

class="form-control mb-3"

value="<?=htmlspecialchars($product['product_code']);?>"

required>





<label>

Category

</label>


<input

type="text"

name="category"

class="form-control mb-3"

value="<?=htmlspecialchars($product['category']);?>">





<label>

Brand

</label>


<input

type="text"

name="brand"

class="form-control mb-3"

value="<?=htmlspecialchars($product['brand']);?>">






<div class="row">


<div class="col-md-6">


<label>

Purchase Price

</label>


<input

type="number"

step="0.01"

name="purchase_price"

class="form-control mb-3"

value="<?=$product['purchase_price'];?>">


</div>





<div class="col-md-6">


<label>

Selling Price

</label>


<input

type="number"

step="0.01"

name="selling_price"

class="form-control mb-3"

value="<?=$product['selling_price'];?>">


</div>


</div>






<label>

Quantity

</label>


<input

type="number"

name="quantity"

class="form-control mb-3"

value="<?=$product['quantity'];?>">





<label>

Unit

</label>


<select

name="unit"

class="form-select mb-3">



<option><?=$product['unit'];?></option>

<option>Nos</option>

<option>Kg</option>

<option>Box</option>

<option>Pack</option>

<option>Litre</option>


</select>






<label>

Description

</label>


<textarea

name="description"

class="form-control mb-3"

rows="4">

<?=$product['description'];?>

</textarea>






<label>

Change Image

</label>


<input

type="file"

name="image"

class="form-control mb-3">






<?php if($product["image"]!=""): ?>


<img
src="../uploads/<?=$product['image'];?>"
width="100"
height="100"
style="object-fit:cover;border-radius:10px;">


<?php endif; ?>







<button

type="submit"

name="update_product"

class="btn btn-primary">


Update Product


</button>



<a

href="../index.php"

class="btn btn-secondary">


Cancel


</a>





</form>


</div>


</div>



</body>

</html>