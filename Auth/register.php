<?php
session_start();
require_once "../includes/db.php";

if(isset($_POST['register'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = "user";

    $check = mysqli_prepare($conn,"SELECT id FROM users WHERE username=?");
    mysqli_stmt_bind_param($check,"s",$username);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);

    if(mysqli_num_rows($result)>0){

        $error = "Username already exists.";

    }else{

        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn,"INSERT INTO users(username,password,role) VALUES(?,?,?)");
        mysqli_stmt_bind_param($stmt,"sss",$username,$hashedPassword,$role);

        if(mysqli_stmt_execute($stmt)){
            header("Location: login.php");
            exit();
        }else{
            $error = "Registration Failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-4">

<div class="card">

<div class="card-header">
<h3 class="text-center">Register</h3>
</div>

<div class="card-body">

<?php
if(isset($error)){
    echo "<div class='alert alert-danger'>$error</div>";
}
?>

<form method="POST">

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button class="btn btn-success w-100" name="register">
Register
</button>

</form>

<br>

<a href="login.php">Already have an account?</a>

</div>

</div>

</div>

</div>

</div>

</body>
</html>