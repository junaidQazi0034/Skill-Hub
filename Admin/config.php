<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "skillhub_db";
$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {

}
?>