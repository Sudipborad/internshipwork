<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>

<body>
    <?php
    require 'connect.php';
    $obj = new Connect();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $row = $obj->getdata($id);

        if (isset($_POST['update'])) {
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $mobile = $_POST["number"];
            $id = $_POST['id'];

            $newimageName = $_FILES["image"]["name"];
            $tempName = $_FILES["image"]["tmp_name"];
            $imageType = $_FILES["image"]["type"];
            $imageSize = $_FILES["image"]["size"];

            if (!empty($newimageName)) {
                $updateimagename = $newimageName;
            } else {
                $updateimagename = $row['image'];
            }

            $data = [
                'fullname'  => $fullname,
                'email'     => $email,
                'mobile'    => $mobile,
                'imgname'   => $updateimagename,
                'tmp_name'  => $tempName,
                'size'      => $imageSize,
                'type'      => $imageType,
                'id'        => $id,
                'oldimage'  => $row['image']
            ];

            $obj->update($data);
        }
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <label for="firstname">Name: </label>
        <input type="text" name="fullname" value="<?php echo $row["name"]; ?>">
        <br>
        <label for="email">Email: </label>
        <input type="email" name="email" value="<?php echo $row["email"]; ?>">
        <br>
        <label for="password">Mobile: </label>
        <input type="number" name="number" value="<?php echo $row["number"]; ?>">
        <br><br>

        <img height="70px" width="70px" style="border-radius: 100%;" src="./upload/<?php echo $row['image']; ?>"><br><br>

        <label for="image">Update Image</label><br>
        <input type="file" accept="image/*" name="image">
        <br><br>

        <input type="hidden" name='id' value="<?php echo $id; ?>">
        <input type="submit" value="Update" name="update">
    </form>

</body>

</html>