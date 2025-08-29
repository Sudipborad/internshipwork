<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example-1</title>
</head>

<body>
    <?php

    require 'connection.php';

    $obj = new Connect();


    if (isset($_POST["submit"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];

        $obj->insert($_POST);
    }

    ?>
    <form method="post">
        <label for="firstname">Name: </label>
        <input type="text" name="name">
        <br>
        <label for="email">email: </label>
        <input type="email" name="email">
        <br>
        <label for="password">Mobile: </label>
        <input type="number" name="mobile">
        <br>
        <input type="submit" value="Submit" name="submit">
    </form>
</body>

</html>