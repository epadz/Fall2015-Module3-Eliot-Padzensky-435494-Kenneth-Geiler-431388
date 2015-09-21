<?php
require "config.php";
require "functions.php";
session_start();

if(!isset($_POST['fname']) || !isset($_POST['lname']) || !isset($_POST['username']) || !isset($_POST['password'])){
	header("Location: ../login.php?error=1");
}
//NEED INPUT FILTERING HERE!

$fn = $_POST['fname'];
$ln = $_POST['lname'];
$un = $_POST['username'];
$pw = $_POST['password'];

//checks if the user exists. if not, then create the account
if(!isUser($un)){
	$cpt_pwd = crypt($pw);
	
	$stmt = $mysqli->prepare("insert into users (first_name, last_name, user_name, password) values (?, ?, ?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('ssss', $fn, $ln, $un, $cpt_pwd);	 
	$stmt->execute();	 
	$stmt->close();
	
	$ud = checkLogin($un, $pw);
	if(isset($ud)){
		$_SESSION['uid'] = $ud['uid'];
		$_SESSION['username'] = $ud['un'];
		$_SESSION['fname'] = $ud['fn'];
		$_SESSION['lname'] = $ud['ln'];
		header("Location: ../index.php");
	}else{
		header("Location: ../login.php?error=3");
	}
}else{
	header("Location: ../login.php?error=2");
}
 
?>