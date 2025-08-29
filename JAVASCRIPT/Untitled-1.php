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

    // Handle final form submission
    if (isset($_POST["submit"])) {
        $name = $_POST["name"];
        $description = $_POST["description"];

        // Determine the last selected category (deepest level)
        $pid = 0;
        if (!empty($_POST["selected_categories"])) {
            $selected = $_POST["selected_categories"];
            $lastCategoryName = end($selected);

            if ($lastCategoryName != 'parent') {
                $catRow = $obj->getid($lastCategoryName);
                $pid = $catRow['id'];
            }
        }

        // Handle multiple images
        $img_arr = [];
        $timg_arr = [];
        $count = count($_FILES['image']['name']);
        for ($i = 0; $i < $count; $i++) {
            $img_arr[] = $_FILES["image"]["name"][$i];
            $timg_arr[] = $_FILES["image"]["tmp_name"][$i];
        }

        $data = [
            'name' => $name,
            'category' => $lastCategoryName ?? 'parent',
            'pid' => $pid,
            'description' => $description,
            'imgname' => $img_arr,
            'tmp_name' => $timg_arr,
        ];
        $obj->insert($data);
    }

    // Get selected categories so far
    $selected_categories = $_POST["selected_categories"] ?? [];
    ?>

    <form method="post" enctype="multipart/form-data">
        <!-- Product Name -->
        <label>Name</label><br>
        <input type="text" name="name" placeholder="Product name"><br><br>

        <!-- Category Dropdowns -->
        <?php
        $parentId = 0;
        $level = 0;
        do {
            $categories = $obj->getcategorylevel1($parentId);
            if ($categories->num_rows > 0) {
                echo "<label>Select Category Level " . ($level + 1) . "</label><br>";
                echo "<select name='selected_categories[]'>";
                echo "<option value='parent'>Select category</option>";
                while ($row = $categories->fetch_assoc()) {
                    $selectedValue = $selected_categories[$level] ?? '';
                    $selected = ($selectedValue === $row['name']) ? 'selected' : '';
                    echo "<option value='{$row['name']}' $selected>{$row['name']}</option>";
                }
                echo "</select><br><br>";

                // Update parent ID for next level
                $selectedCategoryName = $selected_categories[$level] ?? null;
                if ($selectedCategoryName && $selectedCategoryName != 'parent') {
                    $cat = $obj->getid($selectedCategoryName);
                    $parentId = $cat['id'];
                } else {
                    break;
                }
                $level++;
            } else {
                break;
            }
        } while (true);
        ?>

        <button type="submit" name="cat_next">Submit to add next subcategory</button><br><br>

        <!-- Image Upload -->
        <label>Upload Images</label><br>
        <input type="file" name="image[]" accept="image/*" multiple><br><br>

        <!-- Description -->
        <label>Description</label><br>
        <textarea name="description" placeholder="Enter description"></textarea><br><br>

        <!-- Final Submit -->
        <button type="submit" name="submit">Submit Product</button>
        <button type="reset">Reset</button>
    </form>
</body>

</html>