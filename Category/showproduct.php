 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Show Category</title>
 </head>

 <body>
     <?php
        require 'connect.php';
        $obj = new Connect();
        if (isset($_GET["submit"])) {
            $id = $_GET["categoryid"];
        }

        ?>


     <form method="get" enctype="multipart/form-data">

         <select name="categoryid" id="cars">
             <?php
                $result = $obj->getcategory();
                while ($row = $result->fetch_assoc()) { ?>
                 <option value="<?php echo $row['id']; ?>">
                     <?php echo $row['name']; ?>
                 </option>
             <?php } ?>
         </select>
         <br><br>


         <button type="submit" name="submit">Submit</button>
     </form>

     <h2>Product List</h2>
     <table border="1" cellpadding="10">
         <tr>
             <th>ID</th>
             <th>Name</th>
             <th>Parent Category</th>
             <th>Description</th>
             <!-- <th>Image</th> -->
             <th>Edit</th>
             <th>Delete</th>
             <th>View</th>

         </tr>

         <?php
            if (isset($_GET["submit"])) {
                $categories = $obj->getallProducts($id);
                $rowid = 1;
                while ($row = $categories->fetch_array()) {
                     ?>
                 <tr>
                     <td><?php echo $rowid ?></td>
                     <td><?php echo $row['name'] ?></td>
                     <td><?php echo $row['parent_name'] ?></td>
                     <td><?php echo $row['description'] ?></td>
                     <!-- <td><img src='<?php echo "./uploads/" . $row['image']?>' width='120' height='120'> </td> -->
                     <td><a href="editproduct.php?id=<?php echo $row['id']; ?>" onclick='return confirm("Are you sure you want to edit this product.")'>Edit</a></td>
                     <td><a href="deleteproduct.php?id=<?php echo $row['id']; ?>"onclick='return confirm("Are you sure you want to Delete this product.")'>Delete</a></td>
                     <td><a href="viewproduct.php?id=<?php echo $row['id']; ?>">View</a></td>


                 </tr>

         <?php $rowid++;
                }
            }
            ?>
     </table>

 </body>

 </html>