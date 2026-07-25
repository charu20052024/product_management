<?php
include "../includes/db.php";

// Fetch product details using id
?>

<form action="update.php" method="POST">

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>">

    <!-- Other fields -->

    <button type="submit">Update</button>

</form>