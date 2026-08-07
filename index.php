<?php

session_start();


require_once __DIR__ . "/includes/db.php";


// LOGIN CHECK

if(!isset($_SESSION["user_id"])){

    header("Location: auth/login.php");
    exit();

}


$username = $_SESSION["username"] ?? "User";




// =======================
// ADD PRODUCT
// =======================

if(isset($_POST["add_product"])){


$product_name = trim($_POST["product_name"] ?? "");

$product_code = trim($_POST["product_code"] ?? "");

$category = trim($_POST["category"] ?? "");

$brand = trim($_POST["brand"] ?? "");

$purchase_price = $_POST["purchase_price"] ?? 0;

$selling_price = $_POST["selling_price"] ?? 0;

$quantity = $_POST["quantity"] ?? 0;

$unit = $_POST["unit"] ?? "";

$description = trim($_POST["description"] ?? "");




// IMAGE UPLOAD

$image = "";


if(isset($_FILES["image"]) &&
$_FILES["image"]["name"]!=""){


$image_name =
time()."_".$_FILES["image"]["name"];


$upload =
"uploads/products/".$image_name;


move_uploaded_file(

$_FILES["image"]["tmp_name"],

$upload

);


$image=$image_name;


}




$sql = "

INSERT INTO products

(
product_name,
product_code,
category,
brand,
purchase_price,
selling_price,
quantity,
unit,
description,
image
)

VALUES

(?,?,?,?,?,?,?,?,?,?)

";



$stmt=mysqli_prepare($conn,$sql);



if(!$stmt){

die(
"SQL ERROR: ".mysqli_error($conn)
);

}




mysqli_stmt_bind_param(

$stmt,

"ssssddisss",

$product_name,

$product_code,

$category,

$brand,

$purchase_price,

$selling_price,

$quantity,

$unit,

$description,

$image

);



mysqli_stmt_execute($stmt);



header("Location:index.php");

exit();


}






// =======================
// DELETE PRODUCT
// =======================


if(isset($_GET["delete"])){


$id=$_GET["delete"];



$stmt=mysqli_prepare(

$conn,

"DELETE FROM products WHERE id=?"

);



mysqli_stmt_bind_param(

$stmt,

"i",

$id

);



mysqli_stmt_execute($stmt);



header("Location:index.php");

exit();


}





// =======================
// FETCH PRODUCTS
// =======================


$result=mysqli_query(

$conn,

"SELECT * FROM products ORDER BY id DESC"

);



?>
<!DOCTYPE html>

<html lang="en">


<head>


<meta charset="UTF-8">


<meta name="viewport" content="width=device-width, initial-scale=1.0">



<title>
Product Management
</title>




<!-- Bootstrap CSS -->

<link 
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">



<!-- Bootstrap Icons -->

<link 
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
rel="stylesheet">






<style>


*{

box-sizing:border-box;

}



body{


margin:0;

background:#f4f6f9;

font-family:

Arial, Helvetica, sans-serif;


}





/* NAVBAR */


.navbar{


background:

linear-gradient(
135deg,
#667eea,
#764ba2
);


padding:15px 0;


}



.navbar-brand{


color:white!important;

font-size:24px;

font-weight:bold;


}






/* USER AREA */


.user-area{


color:white;

font-size:15px;


}





/* MAIN CONTAINER */


.container-box{


padding:30px;

}





/* PAGE HEADER */


.page-header{


background:white;

padding:25px;

border-radius:15px;

box-shadow:

0 5px 20px rgba(0,0,0,.08);


display:flex;

justify-content:space-between;

align-items:center;


}



.page-header h2{


margin:0;

font-weight:bold;


}







/* ADD BUTTON */


.add-btn{


background:#667eea;

color:white;

border:none;

padding:12px 20px;

border-radius:10px;

font-weight:bold;


}



.add-btn:hover{


background:#5568d9;

color:white;


}






/* CARD */


.card-box{


background:white;

margin-top:25px;

padding:25px;

border-radius:15px;


box-shadow:

0 5px 20px rgba(0,0,0,.08);


}







/* PRODUCT IMAGE */


.product-img{


width:60px;

height:60px;

object-fit:cover;

border-radius:10px;

border:1px solid #ddd;


}





/* TABLE */


.table{


vertical-align:middle;


}



.table th{


background:#667eea;

color:white;


}





/* BUTTONS */


.btn{


border-radius:8px;


}






/* MOBILE RESPONSIVE */


@media(max-width:768px){



.page-header{


flex-direction:column;

align-items:flex-start;

gap:15px;


}



.table{


font-size:13px;


}



.product-img{


width:45px;

height:45px;


}



.container-box{


padding:15px;


}



}



</style>



</head>


<body>
    <!-- NAVBAR -->

<nav class="navbar">


<div class="container">


<a class="navbar-brand">


<i class="bi bi-box-seam"></i>

Product Management


</a>





<div class="user-area">


Welcome,

<strong>

<?= htmlspecialchars($username); ?>

</strong>




<a href="auth/logout.php"

class="btn btn-danger btn-sm ms-3">


<i class="bi bi-box-arrow-right"></i>

Logout


</a>


</div>



</div>


</nav>







<!-- MAIN CONTENT -->


<div class="container container-box">





<!-- PAGE HEADER -->


<div class="page-header">



<div>


<h2>

Products

</h2>


<p class="text-muted mb-0">

Manage your products here

</p>


</div>






<button

class="btn add-btn"

data-bs-toggle="modal"

data-bs-target="#addProductModal">


<i class="bi bi-plus-circle"></i>

Add Product


</button>



</div>







<!-- PRODUCT CARD START -->


<div class="card-box">



<h4 class="mb-3">


All Products


<span class="badge bg-primary">


<?= mysqli_num_rows($result); ?>


Products


</span>


</h4>
<!-- ADD PRODUCT MODAL -->


<div class="modal fade" id="addProductModal">


<div class="modal-dialog modal-lg">


<div class="modal-content">



<form method="POST" enctype="multipart/form-data">





<div class="modal-header">


<h5 class="modal-title">

Add New Product

</h5>



<button

type="button"

class="btn-close"

data-bs-dismiss="modal">

</button>



</div>







<div class="modal-body">



<div class="row">



<!-- PRODUCT NAME -->

<div class="col-md-6 mb-3">


<label class="form-label">

Product Name

</label>


<input

type="text"

name="product_name"

class="form-control"

placeholder="Enter product name"

required>


</div>






<!-- PRODUCT CODE -->

<div class="col-md-6 mb-3">


<label class="form-label">

Product Code

</label>


<input

type="text"

name="product_code"

class="form-control"

placeholder="Enter product code"

required>


</div>






<!-- CATEGORY -->


<div class="col-md-6 mb-3">


<label class="form-label">

Category

</label>


<input

type="text"

name="category"

class="form-control"

placeholder="Category">


</div>







<!-- BRAND -->


<div class="col-md-6 mb-3">


<label class="form-label">

Brand

</label>


<input

type="text"

name="brand"

class="form-control"

placeholder="Brand">


</div>







<!-- PURCHASE PRICE -->


<div class="col-md-6 mb-3">


<label class="form-label">

Purchase Price

</label>


<input

type="number"

step="0.01"

name="purchase_price"

class="form-control"

placeholder="0.00">


</div>







<!-- SELLING PRICE -->


<div class="col-md-6 mb-3">


<label class="form-label">

Selling Price

</label>


<input

type="number"

step="0.01"

name="selling_price"

class="form-control"

placeholder="0.00">


</div>







<!-- QUANTITY -->


<div class="col-md-6 mb-3">


<label class="form-label">

Quantity

</label>


<input

type="number"

name="quantity"

class="form-control"

placeholder="Quantity">


</div>







<!-- UNIT -->


<div class="col-md-6 mb-3">


<label class="form-label">

Unit

</label>


<select

name="unit"

class="form-select">



<option value="Nos">

Nos

</option>



<option value="Kg">

Kg

</option>



<option value="Box">

Box

</option>



<option value="Pack">

Pack

</option>



<option value="Litre">

Litre

</option>



</select>


</div>







<!-- DESCRIPTION -->


<div class="col-12 mb-3">


<label class="form-label">

Description

</label>


<textarea

name="description"

class="form-control"

rows="3"

placeholder="Product description">

</textarea>


</div>







<!-- IMAGE -->


<div class="col-12 mb-3">


<label class="form-label">

Product Image

</label>



<input

type="file"

name="image"

class="form-control"

accept="image/*">


</div>



</div>



</div>







<div class="modal-footer">


<button

type="button"

class="btn btn-secondary"

data-bs-dismiss="modal">


Close


</button>





<button

type="submit"

name="add_product"

class="btn btn-primary">


<i class="bi bi-save"></i>

Save Product


</button>



</div>





</form>




</div>


</div>


</div>
<!-- PRODUCT TABLE -->


<div class="table-responsive">



<table class="table table-bordered table-hover">


<thead>


<tr>


<th>ID</th>

<th>Image</th>

<th>Product</th>

<th>Code</th>

<th>Category</th>

<th>Brand</th>

<th>Purchase</th>

<th>Selling</th>

<th>Qty</th>

<th>Unit</th>

<th>Action</th>


</tr>


</thead>





<tbody>



<?php if(mysqli_num_rows($result)>0): ?>



<?php while($row=mysqli_fetch_assoc($result)): ?>



<tr>



<td>

<?= $row["id"]; ?>

</td>






<!-- IMAGE -->


<td>

<?php

if(!empty($row['image'])) {

?>

<img
src="uploads/<?=$row['image'];?>"
width="80"
height="80"
style="object-fit:cover;border-radius:8px;">

<?php

}else{

echo "No Image";

}

?>

</td>






<!-- PRODUCT NAME -->


<td>

<?= htmlspecialchars($row["product_name"]); ?>


</td>






<!-- CODE -->


<td>

<?= htmlspecialchars($row["product_code"]); ?>


</td>






<!-- CATEGORY -->


<td>

<?= htmlspecialchars($row["category"]); ?>


</td>






<!-- BRAND -->


<td>

<?= htmlspecialchars($row["brand"]); ?>


</td>






<!-- PURCHASE -->


<td>

₹ <?= $row["purchase_price"]; ?>


</td>






<!-- SELLING -->


<td>

₹ <?= $row["selling_price"]; ?>


</td>






<!-- QUANTITY -->


<td>

<?= $row["quantity"]; ?>


</td>






<!-- UNIT -->


<td>

<?= $row["unit"]; ?>


</td>






<!-- ACTION -->


<td>


<a href="ajax/edit.php?id=<?= $row['id']; ?>"
class="btn btn-success btn-sm">

<i class="bi bi-pencil"></i>
Edit

</a>





<a

href="index.php?delete=<?= $row['id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Are you sure you want to delete this product?');">


<i class="bi bi-trash"></i>

Delete


</a>



</td>





</tr>



<?php endwhile; ?>



<?php else: ?>



<tr>


<td colspan="11"

class="text-center text-danger">


No Products Found


</td>


</tr>



<?php endif; ?>



</tbody>



</table>



</div>




</div>

<!-- CARD BOX END -->
 <!-- Bootstrap JavaScript -->

<script 
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>



</body>


</html>