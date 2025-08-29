    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Get Category</title>
    </head>

    <body>
        <?php

        require 'connect.php';

        $obj = new Connect();


        if (isset($_POST["submit"])) {

            $name = $_POST["name"];
            $category = $_POST["category"];
            if ($category == 'parent') {
                $pid = 0;
            } else {
                $row = $obj->getid($category);
                $pid = $row['id'];
            }
            $description = $_POST["description"];

            $count = count($_FILES['image']['name']);

            $img_arr = [];
            $timg_arr = [];
            for ($i = 0; $i < $count; $i++) {

                $imageName = $_FILES["image"]["name"][$i];
                $tempName = $_FILES["image"]["tmp_name"][$i];
                array_push($img_arr, $imageName);
                array_push($timg_arr, $tempName);
            }



            $data = [
                'name'        => $name,
                'category'    => $category,
                'pid'         => $pid,
                'description' => $description,
                'imgname'     => $img_arr,
                'tmp_name'    => $timg_arr,
            ];


            echo "<pre>";
            print_r($data);

            // $obj->insert($data);
        }

        ?>

        <form method="post" enctype="multipart/form-data">
            <label for="name">Name</label><br>
            <input type="text" id="name" name="name" placeholder=" Product name"><br><br>

            <label for="category">Choose a Category</label>
            <select name="category" id="category" onchange='getcat()'>
                <option value="parent">Select a category</option>
                <?php

                $result = $obj->getcategory();
                while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['name']; ?>
                    </option>
                <?php  } ?>
            </select>
            <br><br>

            <div id="result"></div>

            <label for="image[]">Upload Image</label><br>
            <input type="file" accept="image/*" multiple name="image[]"><br><br>

            <label for="description">Description</label><br>
            <textarea type="text" id="description" name="description" placeholder="Enter description"></textarea><br><br>

            <button type="submit" name="submit">Submit</button>
            <button type="reset" name="reset">Reset</button>
        </form>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <script>
        function getcat() {
            // const newDiv = document.createElement("div");
            // newDiv.id = "uniid";
            var value = document.getElementById('category').value;

            $.ajax({
                url: 'get.php',
                type: 'POST',
                data: {
                    value: value
                },
                success: function(data) {

                    $('#category').html(data);
                }
            });
        }
    </script>

    </html>