<?php

include "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request");
}

$product_name    = trim($_POST['product_name'] ?? '');
$product_code    = trim($_POST['product_code'] ?? '');
$category        = trim($_POST['category'] ?? '');
$brand           = trim($_POST['brand'] ?? '');
$purchase_price  = $_POST['purchase_price'] ?? 0;
$selling_price   = $_POST['selling_price'] ?? 0;
$quantity        = $_POST['quantity'] ?? 0;
$unit            = trim($_POST['unit'] ?? '');
$description     = trim($_POST['description'] ?? '');

if ($product_name === '') {
    exit("Product name is required");
}

if ($product_code === '') {
    exit("Product code is required");
}

if ($category === '') {
    exit("Category is required");
}

if ($brand === '') {
    exit("Brand is required");
}

if ($purchase_price === '' || !is_numeric($purchase_price)) {
    exit("Invalid purchase price");
}

if ($selling_price === '' || !is_numeric($selling_price)) {
    exit("Invalid selling price");
}

if ($quantity === '' || !is_numeric($quantity)) {
    exit("Invalid quantity");
}


/* =========================
   IMAGE UPLOAD
========================= */

$image = "";

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === UPLOAD_ERR_OK
) {

    $uploadDir = "../assets/uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $originalName = basename($_FILES['image']['name']);

    $extension = strtolower(
        pathinfo($originalName, PATHINFO_EXTENSION)
    );

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($extension, $allowed)) {
        exit("Invalid image type");
    }

    $image = time() . "_" . uniqid() . "." . $extension;

    if (!move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $uploadDir . $image
    )) {
        exit("Image upload failed");
    }
}


/* =========================
   INSERT PRODUCT
========================= */

$sql = "INSERT INTO products
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
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    exit("Prepare Error: " . mysqli_error($conn));
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


if (mysqli_stmt_execute($stmt)) {

    echo "success";

} else {

    echo "Database Error: " . mysqli_stmt_error($stmt);
}


mysqli_stmt_close($stmt);
mysqli_close($conn);

?>