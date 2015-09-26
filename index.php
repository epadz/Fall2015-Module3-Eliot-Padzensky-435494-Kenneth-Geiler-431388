<?php
require 'includes/config.php';
require 'includes/functions.php';
session_start();
$loggedIn = true;
if(!isset($_SESSION['username'])){
	$loggedIn = false;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Story Feed</title>
<link href="includes/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php if($loggedIn){
		echo'<a href="includes/logout.php">logout</a>';
	}else{
		echo'<a href="login.php">log in or register</a>';
	}
	?>
    <br>
    <?php
    if($loggedIn){
		echo'
		<div id="postBox">
			<h2>Post a New Story</h2>
			<p id="sError"> </p>
			   <form action="includes/post_story.php" method="post">
				  <input type="text" name="title" id="sTitle" placeholder="Title" required>          
				  <input type="text" name="url" id="sUrl" placeholder="URL" required>          
				  <textarea name="commentary" id="sCommentary" placeholder="Commentary" required></textarea>
				  <input type="submit" value="post!" id="sSubmit">
			  </form>
		</div>';
	}
	?>
    <div id="stories">
        <?php
			if(isset($_GET["error"])){
				if($_GET["error"] == 1){
					echo'<p>you must be logged in to do that!</p>';
				}
			}
			$stories = query();
			foreach($stories as $key => $value){
				echo'
				<div class="story" id="story_' . htmlspecialchars( $value["story_id"] ) . '">
					<a class="title" href="' . htmlspecialchars( $value["url"] ) . '">' . htmlspecialchars( $value["title"] ) . '</a>
					<div class="commentary">' . htmlspecialchars( $value["commentary"] ) . '</div>
					<div class="bottomBar">
						<a href="story.php?id=' . htmlspecialchars( $value["story_id"] ) . '">' . $value["comments_num"] . ' comments&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
						<a href="includes/upvote.php?id=' . htmlspecialchars( $value["story_id"] ) . '">&#128077;</a>
						<div class="votes">' . $value["vote"] . '</div>
						<a href="includes/downvote.php?id=' . htmlspecialchars( $value["story_id"] ) . '">&#128078;</a>
					</div>
				</div>
				';
			}
		?>        
    </div>
</body>
</html>
