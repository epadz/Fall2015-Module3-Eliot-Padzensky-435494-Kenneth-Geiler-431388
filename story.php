<?php
require 'includes/config.php';
require 'includes/functions.php';
session_start();
$loggedIn = true;;
if(!isset($_SESSION['username'])){
	$loggedIn = false;
}
if(!isset($_GET['id'])){
	header("Location: index.php");
}
$story_ID = $_GET['id'];
$story = getStory($story_ID);
$title = $story["title"];
$comments = getComments($story_ID);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<link href="includes/style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<a href="index.php">go back</a>
    <div id="stories">
    	<?php
		echo'
			<div class="pstory" id="story_' . htmlspecialchars( $story["story_id"] ) . '">
				<a class="title" href="' . htmlspecialchars( $story["url"] ) . '">' . htmlspecialchars( $story["title"] ) . '</a>
				<div class="commentary">' . htmlspecialchars( $story["commentary"] ) . '</div>
				<div class="bottomBar">					
					<a href="includes/upvote.php?id=' . htmlspecialchars( $story["story_id"] ) . '">&#128077;</a>
					<div class="votes">' . $story["vote"] . '</div>
					<a href="includes/downvote.php?id=' . htmlspecialchars( $story["story_id"] ) . '">&#128078;</a>
				</div>
			</div>';
		if($loggedIn){
			echo'
			<div class="story" style="height:250px;">
				<div class="title">Leave a Comment</div>
				<form action="includes/post_comment.php?id=' . htmlspecialchars( $story["story_id"] ) . '" method="post">
				  <textarea name="comment" id="sCommentary" placeholder="Comment" required></textarea>
				  <input type="submit" id="sSubmit" value="post!">
				</form>
			</div>';		
		}
		foreach($comments as $col => $val){
			echo'<div class="story">
				<div class="title">User ' . $val['user_name'] . ' says:</div>
				<div class="commentary">'. $val['comment'] . '</div>
			</div>';
		}
		?>
    </div>
</body>
</html>
