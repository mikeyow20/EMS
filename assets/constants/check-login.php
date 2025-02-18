<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

$myusername = $_SESSION['username'];
$myavatar = $_SESSION['avatar'];

}else{

header("location:../");

}

?>