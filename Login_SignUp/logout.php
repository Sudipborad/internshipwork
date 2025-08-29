<?php
session_start();
session_destroy();
setcookie('name', '', time() - 60 * 5);
header("Location: showdata.php");
// echo"<script>alert('You have been logged out!');
// window.location = 'login.php';
// </script>"
