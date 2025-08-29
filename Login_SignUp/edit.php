<?php
session_start();
if (!isset($_COOKIE['name']) && !isset($_SESSION['name'])) {
    echo "<script>alert('You are not logged in! First login!');
        window.location = 'login.php'
        </script>";
}
?>
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

        $result = $obj->getdata($id);
        $row = $result->fetch_assoc();
        if (isset($_POST['update'])) {
            $name = $_POST["name"];
            $description = $_POST["description"];
            $parent_id = $_POST["category"];
            $id = $_POST['id'];
            $count = count($_FILES['image']['name']);

            $img_arr = [];
            $timg_arr = [];

            if (!empty($_FILES['image']['name'][0])) {
                for ($i = 0; $i < $count; $i++) {

                    $imageName = $_FILES["image"]["name"][$i];
                    $tempName = $_FILES["image"]["tmp_name"][$i];
                    array_push($img_arr, $imageName);
                    array_push($timg_arr, $tempName);
                }
            }
            $data = [
                'name'  => $name,
                'description'     => $description,
                'parent_id'    => $parent_id,
                'imgname'   => $img_arr,
                'tmp_name'  => $timg_arr,
                'id'        => $id,
                'oldimage'  => $row['image']
            ];
            if (!isset($_COOKIE['name']) && !isset($_SESSION['name'])) {
                echo "<script>alert('You are not logged in! First login!');
        window.location = 'login.php'
        </script>";
            } else {
                $obj->update($data);
            }
        }
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <label for="name">Name: </label>
        <input type="text" name="name" value="<?php echo $row["name"]; ?>">

        <br><br>
        <label for="description">Description</label>
        <input type="text" name="description" value="<?php echo $row["description"]; ?>">
        <br><br>
        <select name="category" id="cars">

            <?php
            $result = $obj->getcategory();
            while ($rows = $result->fetch_assoc()) {
                $check = $row['parent_id'] == $rows['id'] ? "selected" : "";

            ?>
                <option value="<?php echo $rows['id']; ?>" <?php echo $check ?>>
                    <?php echo $rows['name']; ?>
                </option>
            <?php } ?>
        </select>
        <br><br>




        <?php
        $result = $obj->showimage($id);

        while ($rows = $result->fetch_assoc()) { ?>
            <img height="70px" width="70px" style="border-radius: 100%;" src="../Category/uploads/<?php echo $rows['image']; ?>">
            <button type="submit" style="height: 40px; width:50px;" value='<?= $rows["id"] ?>' name="deleteimg"><br>Delete</button><br>

        <?php }
        if (isset($_POST['deleteimg'])) {
            $imgid = $_POST['deleteimg'];

            if (!isset($_COOKIE['name']) && !isset($_SESSION['name'])) {
                echo "<script>alert('You are not logged in! First login!');
        window.location = 'login.php'
        </script>";
            } else {
                $obj->deleteimg($imgid);
            }

        }
        ?>


        <br><br><label for="image">Add Images</label><br>
        <input type="file" accept="image/*" multiple name="image[]">
        <br><br>

        <input type="hidden" name='id' value="<?php echo $id; ?>">
        <input type="submit" value="Update" name="update">
    </form>

</body>

</html>