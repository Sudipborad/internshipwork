
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.6-dist/css/bootstrap.css">

    <title>Sign Up</title>
</head>

<body>
    <?php
    require "connect.php";

    $obj = new Connect();

    if (isset($_POST['submit'])) {
        
        $obj->insert($_POST);
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
                            <div class="form-group mb-3">
                                <label for="text"> Confirm Password </label>
                                <input type="text" class="form-control" id="cpassword" name="cpassword" placeholder="Enter the same Password as above" />
                            </div>
                            <button class="btn btn-primary" name="submit"> Sign Up </button>
                        </form>

                        <p>Already signed in?<a href="login.php">Login</a></p>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>