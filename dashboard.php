
<?php
require_once "Auth/auth_check.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Welcome <?php echo $_SESSION['username']; ?></h2>

<p>Role : <?php echo $_SESSION['role']; ?></p>

<a href="Auth/logout.php" class="btn btn-danger">Logout</a>

</div>

</body>
=======
<?php
require_once "Auth/auth_check.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Welcome <?php echo $_SESSION['username']; ?></h2>

<p>Role : <?php echo $_SESSION['role']; ?></p>

<a href="Auth/logout.php" class="btn btn-danger">Logout</a>

</div>

</body>
</html>