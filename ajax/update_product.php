<?php
include "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $product_name = trim($_POST['product_name']);
    $product_code = trim($_POST['product_code']);
    $category = trim($_POST['category']);
    $brand = trim($_POST['brand']);
    $purchase_price = $_POST['purchase_price'];
    $selling_price = $_POST['selling_price'];
    $quantity = $_POST['quantity'];
    $unit = trim($_POST['unit']);
    $description = trim($_POST['description']);

    $sql = "UPDATE products SET
                product_name = ?,
                product_code = ?,
                category = ?,
                brand = ?,
                purchase_price = ?,
                selling_price = ?,
                quantity = ?,
                unit = ?,
                description = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare Failed: " . mysqli_error($conn));
    }

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

    if (mysqli_stmt_execute($stmt)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>