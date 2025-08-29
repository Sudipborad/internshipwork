<?php
session_start();
if (!isset($_COOKIE['name']) && !isset($_SESSION['name'])) {
    echo "<script>alert('You are not logged in! First login!');
                        window.location = 'login.php'
                        </script>";
}
require 'connect.php';

$obj = new Connect();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $obj->delete($id);
}
