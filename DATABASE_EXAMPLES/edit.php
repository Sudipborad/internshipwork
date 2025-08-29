<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>

<body>
    <?php
    require 'connection.php';
    $obj = new Connect();
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $row=$obj->getdata($id);
        

        if (isset($_POST['update'])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $mobile = $_POST["number"];
            $id = $_POST['id'];
            $obj->update($_POST);
        }
    }
    ?>
    <form method="post">
        <label for="firstname">Name: </label>
        <input type="text" name="name" value="<?php echo $row["name"]; ?>">
        <br>
        <label for="email">email: </label>
        <input type="email" name="email" value="<?php echo $row["email"]; ?>">
        <br>
        <label for="password">Mobile: </label>
        <input type="number" name="number" value="<?php echo $row["number"]; ?>">
        <br>
        <input type="hidden" name ='id'value=<?php echo"$id" ?>>
        <input type="submit" value="Update" name="update">
    </form>

</body>

</html>