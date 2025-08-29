<?php
session_start();
require 'connect.php';
$obj = new Connect();

if (!isset($_SESSION['selected_categories'])) {
    $_SESSION['selected_categories'] = [];
}

if (isset($_POST['next'])) {
    $selected = $_POST['category'] ?? 0;
    $_SESSION['selected_categories'][] = $selected;
}

if (isset($_POST['final_submit'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $image = $_FILES['image'];
    $lastSelected = end($_SESSION['selected_categories']);
    if ($obj->insert($name, $lastSelected, $desc, $image)) {
        echo "<h3>Category inserted successfully!</h3>";
        $_SESSION['selected_categories'] = [];
    } else {
        echo "<h3>Failed to insert category.</h3>";
    }
}
?>

<form method="post">
    <?php
    $parent_id = 0;
    foreach ($_SESSION['selected_categories'] as $selected_id) {
        echo "<select disabled><option>Selected Category ID: $selected_id</option></select><br><br>";
        $parent_id = $selected_id;
    }

    $result = $obj->getChildren($parent_id);
    if ($result->num_rows > 0) {
        echo '<label>Select Category</label><br>';
        echo '<select name="category">';
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        echo '</select><br><br>';
        echo '<button type="submit" name="next">Next</button>';
    } else {
    ?>
        <h3>No more subcategories. Add your own now:</h3>
        <form method="post" enctype="multipart/form-data">
            <label>Name</label><br>
            <input type="text" name="name" required><br><br>

            <label>Description</label><br>
            <textarea name="description" required></textarea><br><br>

            <label>Image</label><br>
            <input type="file" name="image" required><br><br>

            <button type="submit" name="final_submit">Submit Final</button>
        </form>
    <?php } ?>
</form>
