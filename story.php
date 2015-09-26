<?php
require 'includes/config.php';
require 'includes/functions.php';
session_start();
$loggedIn = true;
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
		$storyEditFeats = '';
		if(isset($_SESSION['uid']) && $_SESSION['uid'] == $story['poster_id']){
			$storyEditFeats = '<a href="includes/edit.php?a=e&t=s&id=' . htmlspecialchars( $story["story_id"] ) . '&o=' . htmlspecialchars( $story["story_id"] ) . '">edit&nbsp;&nbsp;&nbsp;&nbsp;</a><a href="includes/edit.php?a=d&t=s&id=' . htmlspecialchars( $story["story_id"] ) . '&o=' . htmlspecialchars( $story["story_id"] ) . '">delete</a>';
		}
		
		
		echo'
			<div class="pstory" id="story_' . htmlspecialchars( $story["story_id"] ) . '">
				<a class="title" href="' . htmlspecialchars( $story["url"] ) . '">' . htmlspecialchars( $story["title"] ) . '</a>
				<div class="commentary">' . htmlspecialchars( $story["commentary"] ) . '</div>
				<div class="bottomBar">					
					<a href="includes/upvote.php?id=' . htmlspecialchars( $story["story_id"] ) . '">&#128077;</a>
					<div class="votes">' . $story["vote"] . '</div>
					<a href="includes/downvote.php?id=' . htmlspecialchars( $story["story_id"] ) . '">&#128078;&nbsp;&nbsp;&nbsp;&nbsp;</a>' .
					$storyEditFeats. '
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
			$commentEditFeats = '';
			if(isset($_SESSION['uid']) && $_SESSION['uid'] == $val['commenter_id']){
				$commentEditFeats = '<div class="bottomBar"><a href="includes/edit.php?a=e&t=c&id=' . htmlspecialchars( $val["comment_id"] ) . '&o=' . htmlspecialchars( $story["story_id"] ) . '">edit&nbsp;&nbsp;&nbsp;&nbsp;</a><a href="includes/edit.php?a=d&t=c&id=' . htmlspecialchars( $val["comment_id"] ) . '&o=' . htmlspecialchars( $story["story_id"] ) . '">delete</a></div>';
			}
			
			echo'<div class="story">
				<div class="title">User ' . $val['user_name'] . ' says:</div>
				<div class="commentary">'. $val['comment'] . '</div>
				' . $commentEditFeats. '
			</div>';
		}
		?>
    </div>
</body>
</html>
