<?php

require_once "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}

$product_name = trim($_POST["product_name"] ?? "");
$product_code = trim($_POST["product_code"] ?? "");
$category = trim($_POST["category"] ?? "");
$brand = trim($_POST["brand"] ?? "");
$purchase_price = (float)($_POST["purchase_price"] ?? 0);
$selling_price = (float)($_POST["selling_price"] ?? 0);
$quantity = (int)($_POST["quantity"] ?? 0);
$unit = trim($_POST["unit"] ?? "");
$description = trim($_POST["description"] ?? "");

if ($product_name == "" || $product_code == "" || $category == "" || $brand == "" || $unit == "") {
    die("Please fill all required fields");
}


/* Check duplicate code */

$check = mysqli_prepare(
    $conn,
    "SELECT id FROM products WHERE product_code = ?"
);

mysqli_stmt_bind_param($check, "s", $product_code);
mysqli_stmt_execute($check);

$result = mysqli_stmt_get_result($check);

if (mysqli_num_rows($result) > 0) {
    die("Product code already exists");
}

mysqli_stmt_close($check);


/* Image */

$image = "";

if (
    isset($_FILES["image"]) &&
    $_FILES["image"]["error"] === UPLOAD_ERR_OK
) {

    $upload_dir = "assets/uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $extension = strtolower(
        pathinfo(
            $_FILES["image"]["name"],
            PATHINFO_EXTENSION
        )
    );

    $allowed = [
        "jpg",
        "jpeg",
        "png",
        "gif",
        "webp"
    ];

    if (!in_array($extension, $allowed)) {
        die("Invalid image format");
    }

    $image =
        time() . "_" .
        uniqid() . "." .
        $extension;

    if (
        !move_uploaded_file(
            $_FILES["image"]["tmp_name"],
            $upload_dir . $image
        )
    ) {
        die("Image upload failed");
    }
}


/* Insert */

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
    die("Database error: " . mysqli_error($conn));
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

    header("Location: index.php?added=1");
    exit();

}

die("Product could not be saved: " . mysqli_stmt_error($stmt));

?>