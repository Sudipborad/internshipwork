<!-- <?php   
// session_start();
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <?php
    
    // if(!isset($_COOKIE['name']) && !isset($_SESSION['name'])){
    //     header("Location: login.php");
    // }

    ?>

<h1>Welcome <?php echo isset($_COOKIE['name'])?$_COOKIE['name'] : $_SESSION['name'] ?></h1>
<a href="logout.php">Logout</a>
</body>
</html> -->