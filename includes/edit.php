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

$content = '';

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
}else if($action == 'e'){
	if(isset($_POST['content'])){
		if($target == 's'){
			$stmt = $mysqli->prepare("update stories set commentary = ? where story_id = ?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('si', $_POST['content'], $item_ID);
			$stmt->execute();
			$stmt->close();
			header("Location: ../story.php?id=" . $origin);
			exit;
		}else if($target == 'c'){
			$stmt = $mysqli->prepare("update comments set comment = ? where comment_id = ?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('si', $_POST['content'], $item_ID);
			$stmt->execute();
			$stmt->close();
			header("Location: ../story.php?id=" . $origin);
			exit;
		}
	}else{
		if($target == 's'){
			$story = getStory($item_ID);
			$content = htmlspecialchars($story['commentary']);
		}else if($target == 'c'){
			$comment = getComment($item_ID);
			$content = htmlspecialchars($comment['comment']);
		}
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<form action="edit.php?a=e&t=<?php echo $target;?>&o=<?php echo $origin;?>&id=<?php echo $item_ID;?>" method="post">
    	<textarea name="content" id="editing">
        	<?php echo $content;?>
        </textarea>
        <input type="submit" value="save"/>
    </form>
</body>
</html>