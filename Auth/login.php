<?php

session_start();

require_once "../includes/db.php";



$error="";


if(isset($_POST["login"])){


$email=trim($_POST["email"] ?? "");

$password=$_POST["password"] ?? "";




if($email==""){

    $error="Email required.";

}
elseif($password==""){

    $error="Password required.";

}
else{


$stmt=mysqli_prepare(

$conn,

"SELECT 
id,
username,
email,
password,
role
FROM users
WHERE email=?
LIMIT 1"

);



if(!$stmt){

    die(
        "SQL ERROR: ".mysqli_error($conn)
    );

}



mysqli_stmt_bind_param(

$stmt,

"s",

$email

);



mysqli_stmt_execute($stmt);



$result=mysqli_stmt_get_result($stmt);



if(mysqli_num_rows($result)==1){


$user=mysqli_fetch_assoc($result);



if(password_verify(
$password,
$user["password"]
)){



$_SESSION["user_id"]=$user["id"];

$_SESSION["username"]=$user["username"];

$_SESSION["user_email"]=$user["email"];

$_SESSION["role"]=$user["role"];



header(
"Location: ../index.php"
);

exit();



}
else{


$error="Wrong password.";


}



}
else{


$error="Email not found.";


}



}


}


?>



<!DOCTYPE html>

<html>

<head>


<title>
Login
</title>


<meta name="viewport" content="width=device-width,initial-scale=1">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">


<div class="container mt-5">


<div class="card shadow p-4 mx-auto"
style="max-width:420px;">



<h3 class="text-center">

Welcome Back

</h3>


<p class="text-center text-muted">

Login to your account

</p>




<?php if($error!=""): ?>


<div class="alert alert-danger">

<?=$error?>

</div>


<?php endif; ?>






<form method="POST">



<label>

Email

</label>


<input

type="email"

name="email"

class="form-control mb-3"

required>




<label>

Password

</label>


<input

type="password"

name="password"

class="form-control mb-3"

required>




<button

name="login"

class="btn btn-primary w-100">

Login

</button>




</form>




<p class="text-center mt-3">

Don't have an account?


<a href="register.php">

Register

</a>


</p>



</div>

</div>


</body>

</html>