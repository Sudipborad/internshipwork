<?php
session_start();
if (isset($_COOKIE['name']) || isset($_SESSION['name'])) {
    echo "<script>alert('You are already logged in!');
            window.location = 'showdata.php';
            </script>";
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.6-dist/css/bootstrap.css">

    <title>Login</title>
</head>

<body>
    <?php
    require "connect.php";
    $obj = new Connect();

    if (isset($_POST['submit'])) {

        $obj->check($_POST);
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-body">
                        <form id="registrationForm" method="post">
                            <div class="form-group mb-3">
                                <label for="name">Name </label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="password"> Password </label>
                                <input type="text" class="form-control" id="password" name="password" placeholder="Enter your Password" />
                            </div>

                            <button class="btn btn-primary w-100" name="submit"> Login </button>

                            <div class="form-check mt-2 ">
                                <input type="checkbox" class="form-check-input" value="rememberme" id="rememberme" name="rememberme">
                                <label class="form-check-label" for="rememberme">Remember me</label>
                            </div>
                        </form>

                        <p>Not signed in?<a href="signup.php">Sign Up</a></p>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>