<?php

include "../includes/db.php";

if(isset($_POST['id'])){

    $id = intval($_POST['id']);

    $sql = "SELECT * FROM products WHERE id='$id'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0){

        echo json_encode(mysqli_fetch_assoc($result));

    }

}

?>