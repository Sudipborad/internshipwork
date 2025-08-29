<?php
require 'connect.php';
    $obj = new Connect();
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $obj->delete($id);

    }
?>