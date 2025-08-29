<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
</head>

<body>
    <?php
    require 'connect.php';
    $obj = new Connect();
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

    ?>
        <table border="1" cellpadding="10">
            <?php
            $results = $obj->getdata($id);
            $rows = $results->fetch_assoc();
            $result = $obj->getProductdata($id);
            $row = $result->fetch_assoc();
            mysqli_data_seek($result, 0);
            ?>

            <tr>
                <th>Name</th>
                <td><?php echo $row['name'] ?></td>
            </tr>

            <tr>
                <th>Parent Category</th>
                <td><?php echo $rows['parent_name'] ?></td>
            </tr>

            <tr>
                <th>Description</th>
                <td><?php echo $row['description'] ?></td>
            </tr>

            <tr>
                <th>Image</th>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <td>
                        <img src='<?php echo "./uploads/" . $row['img'] ?>' width='120' height='120'>
                    </td>
                <?php } ?>
            </tr>
        </table>
    <?php } ?>
</body>

</html>
