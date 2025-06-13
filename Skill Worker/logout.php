<?php
include('navbar.php');
?>
<?php
session_start();

session_destroy();

header("Location: Worker_login.php");
exit();
?>