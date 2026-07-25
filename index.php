<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Auth/login.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "includes/db.php";

$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

echo "<pre>";
echo "Number of products: " . mysqli_num_rows($result);
echo "</pre>";

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Product Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>

/* =========================================
   BASIC
========================================= */

body {
    background: #f8f9fa;
}

.table img {
    width: 60px;
    height: 60px;
    object-fit: cover;
}


/* =========================================
   HEADER - COMMON
========================================= */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    margin-bottom: 25px;
}

.page-title {
    margin: 0;
    font-weight: 600;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

<div class="desktop-products">

    <!-- Product List Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 p-3">

        <div>
            <h5 class="mb-1">Product List</h5>

            <small class="text-secondary">
                Manage your products
            </small>
        </div>

        <span class="badge bg-primary" id="productCount">
            <?= mysqli_num_rows($result); ?> Products
        </span>

    </div>


    <!-- Product Table -->
    <div class="table-responsive">

        <table class="table product-table">
/* =========================================
   DESKTOP TABLE - COMMON
========================================= */

.product-table {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    width: 100%;
}

.product-table th {
    white-space: nowrap;
    vertical-align: middle;
}

.product-table td {
    vertical-align: middle;
}

.product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
}


/* =========================================
   MOBILE CARDS
========================================= */

.mobile-products {
    display: none;
}


/* =========================================
   DESKTOP ONLY
========================================= */

@media (min-width: 769px) {

    body {
        background: #f5f7fb;
    }

    /* Main container */

    .container {
        max-width: 1450px !important;
        width: 94%;
        margin: 0 auto;
        padding-top: 25px;
    }


    /* Header card */

    .page-header {
        background: #ffffff;

        padding: 22px 25px;

        border-radius: 14px;

        border: 1px solid #e9ecef;

        box-shadow: 0 3px 12px rgba(0,0,0,0.05);

        box-sizing: border-box;

        margin-bottom: 20px;
    }


    /* Title */

    .page-title-area {
        flex: 1;
    }

    .page-title {
        font-size: 30px;
        font-weight: 700;
        color: #212529;
        margin: 0;
    }

    .page-subtitle {
        margin: 5px 0 0;
        color: #6c757d;
        font-size: 14px;
    }


    /* Header buttons */

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .action-buttons .btn {
        min-height: 44px;
        padding: 9px 18px;
        border-radius: 8px;
        font-weight: 500;
        white-space: nowrap;
        margin-bottom: 0;
    }


    /* Product table container */

    .desktop-products {
        width: 100%;

        background: #ffffff;

        border-radius: 14px;

        border: 1px solid #e9ecef;

        box-shadow: 0 3px 12px rgba(0,0,0,0.05);

        overflow: hidden;
    }


    /* Table responsive wrapper */

    .desktop-products .table-responsive {
        width: 100%;
        overflow-x: auto;
    }


    /* Table */

    .product-table {
        width: 100%;
        margin: 0;
        background: #ffffff;
        border-radius: 0;
    }


    .product-table thead th {
        background: #212529;
        color: #ffffff;

        font-size: 14px;
        font-weight: 600;

        padding: 14px 10px;

        white-space: nowrap;
        vertical-align: middle;

        border-color: #343a40;
    }


    .product-table tbody td {
        padding: 12px 10px;

        font-size: 14px;

        vertical-align: middle;

        white-space: nowrap;
    }


    /* Product image */

    .product-image {
        width: 58px;
        height: 58px;

        object-fit: contain;

        border-radius: 8px;

        background: #f8f9fa;

        padding: 3px;
    }


    /* Edit/Delete buttons */

    .product-table .editProduct,
    .product-table .deleteProduct {

        width: 38px;
        height: 38px;

        padding: 0;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        border-radius: 7px;

        margin-right: 4px;
    }

}


/* =========================================
   MOBILE VIEW
========================================= */

@media (max-width: 768px) {

    body {
        background: #f8f9fa;
    }


    .container {
        width: 100%;
        padding: 12px;
    }


    /* Header */

    .page-header {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
        gap: 15px;

        padding: 15px 0;
    }


    .page-title {
        font-size: 22px;
    }


    .action-buttons {
        justify-content: center;
        width: 100%;
    }


    .action-buttons .btn {
        flex: 1;
        margin-bottom: 10px;
    }


    /* Hide desktop table */

    .desktop-products {
        display: none;
    }


    /* Show mobile cards */

    .mobile-products {
        display: block;
    }


    /* Product Card */

    .product-card {
        background: white;

        border-radius: 15px;

        padding: 15px;

        margin-bottom: 15px;

        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }


    /* Product top section */

    .product-card-top {
        display: flex;

        align-items: center;

        gap: 15px;

        margin-bottom: 15px;
    }


    .product-card-image {
        width: 75px;
        height: 75px;

        object-fit: cover;

        border-radius: 10px;

        flex-shrink: 0;
    }


    .product-card-title {
        font-size: 18px;

        font-weight: 600;

        margin: 0;
    }


    .product-card-code {
        color: #6c757d;

        font-size: 13px;

        margin-top: 4px;
    }


    /* Details */

    .product-details {
        border-top: 1px solid #eee;

        padding-top: 12px;
    }


    .product-detail {
        display: flex;

        justify-content: space-between;

        padding: 6px 0;

        font-size: 14px;
    }


    .product-detail-label {
        color: #6c757d;
    }


    .product-detail-value {
        font-weight: 500;

        text-align: right;
    }


    /* Actions */

    .product-actions {
        display: flex;

        gap: 10px;

        margin-top: 15px;
    }


    .product-actions button {
        flex: 1;
    }

}


/* =========================================
   SMALL MOBILE
========================================= */

@media (max-width: 480px) {

    .page-title {
        font-size: 19px;
    }


    .action-buttons .btn {
        font-size: 13px;
    }


    .product-card {
        padding: 12px;
    }

}


/* =========================================
   TOAST NOTIFICATION
========================================= */

.toast {
    border-radius: 10px;

    border: none;

    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.toast-body {
    font-size: 14px;
}


@media (max-width: 576px) {

    .toast-container {
        width: 100%;
        padding: 10px !important;
    }

    .toast {
        width: 100%;
    }

}

</style>
</head>

<body class="bg-light">
<!-- Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3"
     style="z-index:9999;">

    <div id="notificationToast"
         class="toast"
         role="alert"
         aria-live="assertive"
         aria-atomic="true">

        <div class="toast-header">

            <i id="toastIcon"
               class="bi bi-check-circle-fill me-2 text-success"></i>

            <strong id="toastTitle" class="me-auto">
                Success
            </strong>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="toast">
            </button>

        </div>

        <div id="toastMessage" class="toast-body">
            Operation completed successfully.
        </div>

    </div>

</div>
<div class="page-header mb-4">

<h2>
📦 Product Management System
</h2>


<div class="action-buttons">

<div>

<button
type="button"
id="addProduct"
class="btn btn-primary"
data-bs-toggle="modal"
data-bs-target="#productModal">

<i class="bi bi-plus-circle-fill"></i>
Add Product

</button>

<a href="Auth/logout.php" class="btn btn-danger">
Logout
</a>

</div>

</div>

<!-- ==========================
     DESKTOP PRODUCT TABLE
=========================== -->

<div class="desktop-products">

<div class="table-responsive">

<table class="table table-bordered table-hover product-table">

<thead class="table-dark">

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


<tbody id="productTableBody">


<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td>
<?= $row['id']; ?>
</td>


<td>

<?php if($row['image']!=""){ ?>

<img src="assets/uploads/<?= $row['image']; ?>"
class="product-image rounded">

<?php } ?>

</td>


<td>
<?= $row['product_name']; ?>
</td>


<td>
<?= $row['product_code']; ?>
</td>


<td>
<?= $row['category']; ?>
</td>


<td>
<?= $row['brand']; ?>
</td>


<td>
₹<?= $row['purchase_price']; ?>
</td>


<td>
₹<?= $row['selling_price']; ?>
</td>


<td>
<?= $row['quantity']; ?>
</td>


<td>
<?= $row['unit']; ?>
</td>


<td>


<button
class="btn btn-warning btn-sm editProduct"
data-id="<?= $row['id']; ?>">

<i class="bi bi-pencil-square"></i>

</button>



<button
class="btn btn-danger btn-sm deleteProduct"
data-id="<?= $row['id']; ?>">

<i class="bi bi-trash"></i>

</button>


</td>


</tr>


<?php

}

}else{

?>

<tr>

<td colspan="11" class="text-center">

No Products Found

</td>

</tr>


<?php

}

?>


</tbody>

</table>

</div>

</div>




<!-- ==========================
     MOBILE PRODUCT CARDS
=========================== -->


<div class="mobile-products">


<?php


$result_mobile = mysqli_query($conn,
"SELECT * FROM products ORDER BY id DESC"
);



if(mysqli_num_rows($result_mobile)>0){


while($row=mysqli_fetch_assoc($result_mobile)){


?>


<div class="product-card">


<div class="product-card-top">


<?php if($row['image']!=""){ ?>

<img src="assets/uploads/<?= $row['image']; ?>"
class="product-card-image">


<?php } ?>


<div>

<h5 class="product-card-title">

<?= $row['product_name']; ?>

</h5>


<div class="product-card-code">

Code:
<?= $row['product_code']; ?>

</div>

</div>


</div>




<div class="product-details">


<div class="product-detail">

<span class="product-detail-label">
Category
</span>

<span class="product-detail-value">
<?= $row['category']; ?>
</span>

</div>



<div class="product-detail">

<span class="product-detail-label">
Brand
</span>

<span class="product-detail-value">
<?= $row['brand']; ?>
</span>

</div>



<div class="product-detail">

<span class="product-detail-label">
Purchase
</span>

<span class="product-detail-value">
₹<?= $row['purchase_price']; ?>
</span>

</div>



<div class="product-detail">

<span class="product-detail-label">
Selling
</span>

<span class="product-detail-value">
₹<?= $row['selling_price']; ?>
</span>

</div>



<div class="product-detail">

<span class="product-detail-label">
Quantity
</span>

<span class="product-detail-value">
<?= $row['quantity']; ?> <?= $row['unit']; ?>
</span>

</div>



</div>




<div class="product-actions">


<button
class="btn btn-warning editProduct"
data-id="<?= $row['id']; ?>">

<i class="bi bi-pencil-square"></i>
Edit

</button>



<button
class="btn btn-danger deleteProduct"
data-id="<?= $row['id']; ?>">

<i class="bi bi-trash"></i>
Delete

</button>


</div>



</div>


<?php


}


}else{


?>


<div class="text-center">

No Products Found

</div>


<?php

}

?>


</div>
<!-- Add / Edit Product Modal -->

<div class="modal fade" id="productModal" tabindex="-1">

  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="modalTitle">
                    Add Product
                </h4>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <form id="productForm" enctype="multipart/form-data">

                    <!-- Hidden ID -->
                   <input type="hidden" name="id" id="product_id">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text"
                                   class="form-control"
                                   name="product_name"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Code</label>
                            <input type="text"
                                   class="form-control"
                                   name="product_code"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text"
                                   class="form-control"
                                   name="category"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand</label>
                            <input type="text"
                                   class="form-control"
                                   name="brand"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Purchase Price
                            </label>

                            <input type="number"
                                   class="form-control"
                                   name="purchase_price"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Selling Price
                            </label>

                            <input type="number"
                                   class="form-control"
                                   name="selling_price"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Quantity
                            </label>

                            <input type="number"
                                   class="form-control"
                                   name="quantity"
                                   required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Unit
                            </label>

                            <select class="form-select"
                                    name="unit"
                                    required>

                                <option value="">
                                    Select Unit
                                </option>

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

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea class="form-control"
                                      rows="3"
                                      name="description"></textarea>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Product Image
                            </label>

                            <input type="file"
                                   class="form-control"
                                   name="image"
                                   accept="image/*">

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Close
                </button>

               <button
    type="button"
    id="saveProduct"
    class="btn btn-success">
    Save Product
</button>

            </div>

        </div>

    </div>

</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>

$(document).ready(function(){

    // ==========================
    // SAVE / UPDATE PRODUCT
    // ==========================

    $("#saveProduct").click(function(){

        let productName = $("input[name='product_name']").val().trim();
        let productCode = $("input[name='product_code']").val().trim();

        if(productName==""){
            alert("Product Name is required");
            return;
        }

        if(productCode==""){
            alert("Product Code is required");
            return;
        }

        let formData = new FormData($("#productForm")[0]);

        let url = "ajax/save_product.php";

        if($("#product_id").val()!=""){
            url = "ajax/update_product.php";
        }

        $.ajax({

            url:url,

            type:"POST",

            data:formData,

            processData:false,

            contentType:false,

            success:function(response){

                if(response.trim()=="success"){

                    alert("Product Saved Successfully");

                    location.reload();

                }else{

                    alert(response);

                }

            }

        });

    });



    // ==========================
    // DELETE PRODUCT
    // ==========================

    $(document).on("click",".deleteProduct",function(){

        let id=$(this).data("id");

        if(confirm("Are you sure you want to delete this product?")){

            $.ajax({

                url:"ajax/delete_product.php",

                type:"POST",

                data:{id:id},

                success:function(response){

                    if(response.trim()=="success"){

                        alert("Product Deleted Successfully");

                        location.reload();

                    }else{

                        alert(response);

                    }

                }

            });

        }

    });



    // ==========================
    // EDIT PRODUCT
    // ==========================

    $(document).on("click", ".editProduct", function () {

    let id = $(this).data("id");

    $.ajax({

        url: "ajax/get_product.php",
        type: "POST",
        data: { id: id },
        dataType: "json",

        success: function (product) {

            $("#product_id").val(product.id);

            $("input[name='product_name']").val(product.product_name);
            $("input[name='product_code']").val(product.product_code);
            $("input[name='category']").val(product.category);
            $("input[name='brand']").val(product.brand);
            $("input[name='purchase_price']").val(product.purchase_price);
            $("input[name='selling_price']").val(product.selling_price);
            $("input[name='quantity']").val(product.quantity);
            $("select[name='unit']").val(product.unit);
            $("textarea[name='description']").val(product.description);

            $("#modalTitle").text("Edit Product");
            $("#saveProduct").text("Update Product");

            var modal = new bootstrap.Modal(document.getElementById("productModal"));
            modal.show();

        }, // <-- comma here

        error: function () {

            alert("Unable to load product details.");

        }

    });

});


    // ==========================
    // RESET FORM WHEN ADD BUTTON IS CLICKED
    // ==========================

$("#addProduct").click(function(){

        $("#productForm")[0].reset();

        $("#product_id").val("");

        $("#modalTitle").text("Add Product");

        $("#saveProduct").text("Save Product");

    });

});

</script>
</body>
</html>