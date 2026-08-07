<?php

session_start();

require_once "../includes/db.php";


$error = "";
$success = "";


if(isset($_POST["register"])){


    $username = trim($_POST["username"] ?? "");

    $email = trim($_POST["email"] ?? "");

    $password = $_POST["password"] ?? "";

    $confirm_password = $_POST["confirm_password"] ?? "";



    // VALIDATION

    if($username==""){

        $error="Username is required.";

    }
    elseif(strlen($username)<3){

        $error="Username must contain 3 characters.";

    }
    elseif($email==""){

        $error="Email is required.";

    }
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){

        $error="Enter valid email.";

    }
    elseif($password==""){

        $error="Password is required.";

    }
    elseif($password != $confirm_password){

        $error="Passwords do not match.";

    }
    else{


        // CHECK EMAIL


        $check = mysqli_prepare(
            $conn,
            "SELECT id FROM users WHERE email=? LIMIT 1"
        );


        mysqli_stmt_bind_param(
            $check,
            "s",
            $email
        );


        mysqli_stmt_execute($check);


        $result=mysqli_stmt_get_result($check);



        if(mysqli_num_rows($result)>0){


            $error="Email already registered.";


        }
        else{


            $hashed_password=password_hash(
                $password,
                PASSWORD_DEFAULT
            );



            $role="user";



            $stmt=mysqli_prepare(
                $conn,
                "INSERT INTO users
                (username,email,password,role)
                VALUES(?,?,?,?)"
            );



            if(!$stmt){

                die(
                    "SQL ERROR: ".mysqli_error($conn)
                );

            }




            mysqli_stmt_bind_param(

                $stmt,

                "ssss",

                $username,

                $email,

                $hashed_password,

                $role

            );




            if(mysqli_stmt_execute($stmt)){


                $success="Registration successful. Login now.";


            }
            else{


                $error="Registration failed.";

            }



        }



    }


}

?>



<!DOCTYPE html>

<html>

<head>

<title>
Register
</title>


<meta name="viewport" content="width=device-width,initial-scale=1">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


</head>



<body class="bg-light">



<div class="container mt-5">


<div class="card shadow p-4 mx-auto"
style="max-width:420px;">


<h3 class="text-center mb-4">

Create Account

</h3>



<?php if($error!=""): ?>

<div class="alert alert-danger">

<?=$error?>

</div>

<?php endif; ?>



<?php if($success!=""): ?>

<div class="alert alert-success">

<?=$success?>

</div>

<?php endif; ?>





<form method="POST">



<label>

Username

</label>


<input

type="text"

name="username"

class="form-control mb-3"

required>




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




<label>

Confirm Password

</label>


<input

type="password"

name="confirm_password"

class="form-control mb-3"

required>





<button

class="btn btn-primary w-100"

name="register">

Register

</button>




</form>




<p class="text-center mt-3">


Already have account?

<a href="login.php">

Login

</a>


</p>



</div>


</div>



</body>

</html>