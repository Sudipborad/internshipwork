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
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        
        <?php
        require 'connection.php';
        $obj = new Connect();
        $result =$obj->showdata();
        $idn = 1;
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $email = $row["email"];
            $mobile = $row["number"];
            echo "      <tr><td>$idn</td><td>$name</td><td>$email</td><td>$mobile</td>";
            echo "<td><a href='edit.php?id={$row["id"]}'>Edit</a></td>";
            echo "<td><a href='delete.php?id={$row["id"]}'>Delete</a></td></tr> ";
            $idn++;
        }
        
        ?>
         
    </table>
</body>

</html>