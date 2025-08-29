<?php 
require 'connect.php';
$obj = new Connect();

$pid=$_POST['value'];
?>
            <div id="<?php $row;?>"></div>
            <label for="category">Choose a Category</label>
            <select name="category" id="category" onchange="getcat()">
                <option value="parent">Select a category</option>
                <?php
                $result = $obj->getcategorylevel1($pid);
                while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['name']; ?>
                    </option>   
                <?php  } ?>
            </select>
            <br><br>
