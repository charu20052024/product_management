<?php
include "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_code = $_POST['product_code'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $purchase_price = $_POST['purchase_price'];
    $selling_price = $_POST['selling_price'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $description = $_POST['description'];

    $sql = "UPDATE products SET
        product_name='$product_name',
        product_code='$product_code',
        category='$category',
        brand='$brand',
        purchase_price='$purchase_price',
        selling_price='$selling_price',
        quantity='$quantity',
        unit='$unit',
        description='$description'
        WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo mysqli_error($conn);
    }
}
?>