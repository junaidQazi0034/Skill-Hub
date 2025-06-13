<?php
include('navbar.php');
?>
<?php
session_start();

session_destroy();

header("Location: user_login.php");
exit();
?>