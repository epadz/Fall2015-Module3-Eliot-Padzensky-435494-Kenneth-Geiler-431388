<?php
require 'config.php';
require 'functions.php';
session_start();
if(!isset($_SESSION['username'])){
	header("Location: ../index.php?error=1");
	exit;
}
if(!isset($_GET['id']) || !isset($_GET['t']) || !isset($_GET['a']) || !isset($_GET['o'])){
	header("Location: ../index.php");
	exit;
}
$user = $_SESSION['username'];
$uid = $_SESSION['uid'];
$item_ID = $_GET['id'];
$action = $_GET['a'];
$target = $_GET['t'];
$origin = $_GET['o'];

if($action == 'd'){
	if($target == 's'){
		$story = getStory($item_ID);
		if($uid == $story["poster_id"]){
			deleteStory($item_ID);
			header("Location: ../index.php");
			exit;
		}else{
			header("Location: ../index.php?error=1");
			exit;
		}
	}else if($target == 'c'){
		$comment = getComment($item_ID);
		if($uid == $comment["commenter_id"]){
			deleteComment($item_ID);
			header("Location: ../story.php?id=" . $origin);
			exit;
		}else{
			header("Location: ../index.php?error=1");
			exit;
		}
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit</title>
<link href="includes/style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<form>
    	<textarea>
        </textarea>
    </form>
</body>
</html>