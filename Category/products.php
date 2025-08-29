    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Get Products</title>
    </head>

    <body>
        <?php

        require 'connect.php';

        $obj = new Connect();

        if (isset($_POST["submit"])) {
            $merarr=array_merge($_FILES,$_POST);
            $obj->insertproduct($merarr);
        }
        ?>

        <form method="post" enctype="multipart/form-data">
            <label for="name">Name</label><br>
            <input type="text" name="name" placeholder="Product name"><br><br>

            <label for="category">Choose a Category</label>
            <select name="category" id="cars">
                <?php
                $result = $obj->getcategory();
                while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['name']; ?>">
                        <?php echo $row['name']; ?>
                    </option>
                <?php } ?>
            </select>
            <br><br>

            <label for="image">Upload Image</label><br>
            <input type="file" accept="image/*" multiple name="image[]"><br><br>

            <label for="description">Description</label><br>
            <textarea type="text" id="description" name="description" placeholder="Enter description"></textarea><br><br>

            <button type="submit" name="submit">Submit</button>
            <button type="reset" name="reset">Reset</button>
        </form>
    </body>

    </html>