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

        $result = $obj->productdata($id);
        $row=$result->fetch_assoc();
        if (isset($_POST['update'])) {
            $merarr=$_POST;
            
            if (!empty($_FILES['image']['name'][0])) {
            $merarr=array_merge($_FILES,$_POST);
            }

            // echo"<pre>";
            // print_r($merarr);
            
            
            $obj->updateproduct($merarr);
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
                $check = $row['category_id'] == $rows['id'] ? "selected" : "";

            ?>
                <option value="<?php echo $rows['id']; ?>" <?php echo $check ?>>
                    <?php echo $rows['name']; ?>
                </option>
            <?php } ?>
        </select>
        <br><br>

            <?php
        $result= $obj->showproductimage($id);

        while ($rows = $result->fetch_assoc()) { ?>
            <img height="70px" width="70px" style="border-radius: 100%;" src="./uploads/products/<?php echo $rows['image']; ?>">
            <button type="submit" style="height: 40px; width:50px;"   value='<?= $rows["id"] ?>' name="deleteimg"><br>Delete</button><br>

        <?php }
        if(isset($_POST['deleteimg'])){
            $imgid=$_POST['deleteimg'];

            $obj->deleteproductimg($imgid);
         
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