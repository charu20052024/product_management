<?php
include "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_name = $_POST['product_name'];
    $product_code = $_POST['product_code'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $purchase_price = $_POST['purchase_price'];
    $selling_price = $_POST['selling_price'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $description = $_POST['description'];

    // Image Upload
    $image = "";

    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {

        $image = time() . "_" . basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../assets/uploads/" . $image
        );
    }

    $stmt = $conn->prepare("INSERT INTO products
    (product_name, product_code, category, brand, purchase_price, selling_price, quantity, unit, description, image)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
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

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>