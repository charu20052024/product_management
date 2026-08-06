<?php
include "../includes/db.php";

if(isset($_POST['id'])){

    $id = intval($_POST['id']);

    // Get image name
    $result = mysqli_query($conn, "SELECT image FROM products WHERE id=$id");
    $row = mysqli_fetch_assoc($result);

    // Delete image file
    if($row && !empty($row['image'])){
        $path = "../assets/uploads/" . $row['image'];

        if(file_exists($path)){
            unlink($path);
        }
    }

    // Delete record
    if(mysqli_query($conn, "DELETE FROM products WHERE id=$id")){
        echo "success";
    }else{
        echo mysqli_error($conn);
    }
}
?>