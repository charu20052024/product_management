<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "includes/db.php";

$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");

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

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📦 Product Management System</h2>

    <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#productModal">
        <i class="bi bi-plus-circle"></i> Add Product
    </button>
</div>

<table class="table table-bordered table-hover text-center align-middle">

<thead class="table-dark">

<tr>
    <th>ID</th>
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

<?php if(mysqli_num_rows($result)>0){ ?>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['id']; ?></td>
<td><?= $row['product_name']; ?></td>
<td><?= $row['product_code']; ?></td>
<td><?= $row['category']; ?></td>
<td><?= $row['brand']; ?></td>
<td><?= $row['purchase_price']; ?></td>
<td><?= $row['selling_price']; ?></td>
<td><?= $row['quantity']; ?></td>
<td><?= $row['unit']; ?></td>

<td>

<button class="btn btn-warning btn-sm editProduct"
        data-id="<?= $row['id']; ?>">
<i class="bi bi-pencil-square"></i>
</button>

<button class="btn btn-danger btn-sm deleteProduct"
        data-id="<?= $row['id']; ?>">
<i class="bi bi-trash"></i>
</button>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="10">
No Products Found
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>


<div class="modal fade" id="productModal">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<div class="modal-header">

<h4 class="modal-title">Product</h4>

<button class="btn-close"
        data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<form id="productForm">

<input type="hidden"
       id="product_id"
       name="id">

<div class="row">

<div class="col-md-6 mb-3">
<label>Product Name</label>
<input type="text"
       class="form-control"
       name="product_name"
       required>
</div>

<div class="col-md-6 mb-3">
<label>Product Code</label>
<input type="text"
       class="form-control"
       name="product_code"
       required>
</div>

<div class="col-md-6 mb-3">
<label>Category</label>
<input type="text"
       class="form-control"
       name="category">
</div>

<div class="col-md-6 mb-3">
<label>Brand</label>
<input type="text"
       class="form-control"
       name="brand">
</div>

<div class="col-md-6 mb-3">
<label>Purchase Price</label>
<input type="number"
       class="form-control"
       name="purchase_price">
</div>

<div class="col-md-6 mb-3">
<label>Selling Price</label>
<input type="number"
       class="form-control"
       name="selling_price">
</div>

<div class="col-md-6 mb-3">
<label>Quantity</label>
<input type="number"
       class="form-control"
       name="quantity">
</div>

<div class="col-md-6 mb-3">

<label>Unit</label>

<select class="form-control"
        name="unit">

<option value="">Select</option>
<option>Nos</option>
<option>Kg</option>
<option>Box</option>
<option>Pack</option>
<option>Litre</option>

</select>

</div>

<div class="col-md-12 mb-3">

<label>Description</label>

<textarea class="form-control"
          rows="3"
          name="description"></textarea>

</div>

</div>

</form>

</div>

<div class="modal-footer">

<button class="btn btn-secondary"
        data-bs-dismiss="modal">
Close
</button>

<button class="btn btn-success"
        id="saveProduct">
Save Product
</button>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function () {

    // ==========================
    // Save / Update Product
    // ==========================
    $("#saveProduct").click(function () {

        let productName = $("input[name='product_name']").val().trim();
        let productCode = $("input[name='product_code']").val().trim();

        if (productName == "") {
            alert("Product Name is required");
            return;
        }

        if (productCode == "") {
            alert("Product Code is required");
            return;
        }

        let id = $("#product_id").val();

        let url = "ajax/save_product.php";

        if (id != "") {
            url = "ajax/update_product.php";
        }

        $.ajax({

            url: url,
            type: "POST",
            data: $("#productForm").serialize(),

            success: function (response) {

                if (response.trim() == "success") {

                    alert(id == "" ? "Product Added Successfully" : "Product Updated Successfully");

                    location.reload();

                } else {

                    alert(response);

                }

            },

            error: function () {

                alert("Something went wrong.");

            }

        });

    });


    // ==========================
    // Delete Product
    // ==========================
    $(document).on("click", ".deleteProduct", function () {

        let id = $(this).data("id");

        if (confirm("Delete this product?")) {

            $.ajax({

                url: "ajax/delete_product.php",
                type: "POST",
                data: { id: id },

                success: function (response) {

                    if (response.trim() == "success") {

                        alert("Product Deleted Successfully");

                        location.reload();

                    } else {

                        alert(response);

                    }

                }

            });

        }

    });


    // ==========================
    // Edit Product
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

                $("#saveProduct").text("Update Product");

                let modal = new bootstrap.Modal(document.getElementById("productModal"));
                modal.show();

            },

            error: function () {

                alert("Unable to load product.");

            }

        });

    });


    // ==========================
    // Reset Modal
    // ==========================
    $('#productModal').on('hidden.bs.modal', function () {

        $("#productForm")[0].reset();

        $("#product_id").val("");

        $("#saveProduct").text("Save Product");

    });

});
</script>

</body>
</html>