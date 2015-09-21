<?php
require "config.php";
require "functions.php";

if(!isset($_POST['username']) || !isset($_POST['password'])){
	header("Location: ../login.php?error=1");
}
//NEED INPUT FILTERING HERE!

$un = $_POST['username'];
$pw = $_POST['password'];

//checks if the user exists. if not, then create the account
$ud = checkLogin($un, $pw);
if(isset($ud)){
	$_SESSION['uid'] = $ud['uid'];
	$_SESSION['username'] = $ud['un'];
	$_SESSION['fname'] = $ud['fn'];
	$_SESSION['lname'] = $ud['ln'];
	header("Location: ../index.php");
}else{
	header("Location: ../login.php?error=0");
}
?>