<?php
include "../includes/db.php";

if(isset($_POST['id'])){

    $id = intval($_POST['id']);

    $result = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");

    if(mysqli_num_rows($result)>0){
        echo json_encode(mysqli_fetch_assoc($result));
    }
}
?>