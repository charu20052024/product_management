<?php
session_start();
require_once "../includes/db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$error = "";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password)){
        $error = "Please enter Username and Password.";
    }else{

        $stmt = mysqli_prepare($conn,"SELECT * FROM users WHERE username=?");
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result)==1){

            $user = mysqli_fetch_assoc($result);

            if(password_verify($password,$user['password'])){

                $_SESSION['user_id']=$user['id'];
                $_SESSION['username']=$user['username'];
                $_SESSION['role']=$user['role'];

                header("Location: ../index.php");
                exit();

            }else{
                $error = "Invalid Username or Password.";
            }

        }else{
            $error = "Invalid Username or Password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{

height:100vh;

display:flex;

justify-content:center;

align-items:center;

background:linear-gradient(135deg,#4facfe,#00f2fe);

font-family:Arial,sans-serif;

}

.card{

width:420px;

border:none;

border-radius:15px;

box-shadow:0 10px 25px rgba(0,0,0,.3);

}

.card-header{

background:#0d6efd;

color:white;

text-align:center;

font-size:25px;

font-weight:bold;

border-radius:15px 15px 0 0;

}

.password-box{

position:relative;

}

.password-box i{

position:absolute;

right:15px;

top:13px;

cursor:pointer;

}

</style>

</head>

<body>

<div class="card">

<div class="card-header">
User Login
</div>

<div class="card-body p-4">

<?php

if($error!=""){

echo "<div class='alert alert-danger'>$error</div>";

}

?>

<form method="POST" id="loginForm" autocomplete="off">

<div class="mb-3">

<label class="form-label">
Username
</label>

<input type="text"
       name="username"
       id="username"
       class="form-control"
       autocomplete="off">

<small id="userError" class="text-danger"></small>

</div>

<div class="mb-3">

<label class="form-label">
Password
</label>

<div class="password-box">

<input type="password"
       name="password"
       id="password"
       class="form-control"
       autocomplete="new-password">

<i class="fa-solid fa-eye" id="togglePassword"></i>

</div>

<small id="passError" class="text-danger"></small>

</div>

<div class="d-grid">

<button
class="btn btn-primary"
name="login">

Login

</button>

</div>

</form>

<hr>

<div class="text-center">

Don't have an account?

<a href="register.php">

Register

</a>

</div>

</div>

</div>

<script>

document.getElementById("loginForm").addEventListener("submit",function(e){

let username=document.getElementById("username").value.trim();

let password=document.getElementById("password").value.trim();

let valid=true;

document.getElementById("userError").innerHTML="";

document.getElementById("passError").innerHTML="";

if(username==""){

document.getElementById("userError").innerHTML="Username is required";

valid=false;

}

if(password==""){

document.getElementById("passError").innerHTML="Password is required";

valid=false;

}
else if(password.length<6){

document.getElementById("passError").innerHTML="Password must contain at least 6 characters";

valid=false;

}

if(!valid){

e.preventDefault();

}

});

document.getElementById("togglePassword").addEventListener("click",function(){

let password=document.getElementById("password");

if(password.type==="password"){

password.type="text";

this.classList.remove("fa-eye");

this.classList.add("fa-eye-slash");

}else{

password.type="password";

this.classList.remove("fa-eye-slash");

this.classList.add("fa-eye");

}

});

</script>

</body>

</html>