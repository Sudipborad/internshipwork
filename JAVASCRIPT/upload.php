<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    if (isset($_POST["submit"])) {
        $imgname = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $filesize = $_FILES["image"]["size"];
        $filetype = $_FILES["image"]["type"];
        $folder = "./upload/" . $imgname;

        echo $filesize;


        $servername = "localhost";
        $username = "root";
        $password = "";
        $db_name = "demo_db";

        $conn = new mysqli($servername, $username, $password, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $allowed = array("image/jpeg", "image/gif", "image/png");
        if (!in_array($filetype, $allowed)) {
            $error_message = '<h2>Only jpg, gif, and png files are allowed.</h2>';
            echo $error_message;
        } else {
            if ($filesize <500000) {
                $sql = "INSERT into imagedemo (image) values ('$imgname')";
                $conn->query($sql);

                if (move_uploaded_file($tempname, $folder)) {
                    echo "<h3>&nbsp; Image uploaded successfully!</h3>";
                } else {
                    echo "<h3>&nbsp; Failed to upload image!</h3>";
                }
            } else {
                echo "<h2>Image upload size limit is 500 KB only</h2>";
            }
        }
    }

    ?>
    <form enctype="multipart/form-data" method="post">
        <input type="file" accept="image/*" name="image">
        <br><br><input type="submit" name="submit">
    </form>

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "demo_db";

    $conn = new mysqli($servername, $username, $password, $db_name);
    $query = " SELECT * from imagedemo ";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
    ?>
        <img height="400px" width="400px" src="./upload/<?php echo $row['image']; ?>">
    <?php
    }
    ?>



</body>

</html>