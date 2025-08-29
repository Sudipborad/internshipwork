<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShowData</title>
</head>

<body>

    <table border='1' cellpadding='10' cellspacing='0'>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Image</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        <?php
        require 'connect.php';
        $obj = new Connect();
        $result = $obj->showdata();
        $idn = 1;
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $email = $row["email"];
            $mobile = $row["number"];
            $image = $row["image"];
            echo "<tr><td>$idn</td><td>$name</td><td>$email</td><td>$mobile</td>";
            echo "<td>" ?>
            <img height="70px" width="70px" style="border-radius: 100%;" src="./upload/<?php echo $row['image']; ?>">


        <?php echo "</td>";
            echo "<td><a href='edit.php?id={$row["id"]}' onclick=\"return confirm('Are you sure you want to edit this record?');\">Edit</a></td>";
            echo "<td><a href='delete.php?id={$row["id"]}' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a></td></tr>";

            $idn++;
        }

        ?>

    </table>
</body>

</html>