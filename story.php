<?php
require 'includes/config.php';
require 'includes/functions.php';
session_start();;
if(!isset($_SESSION['username'])){
	header("Location: login.php?error=4");
}
if(!isset($_GET['id'])){
	header("Location: index.php");
}
$story_ID = $_GET['id'];
$story = getStory($story_ID);
$comments = getComments($story_ID);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
	echo 'User ' . $story['user_name'] . ' posted a link to <a href="' . $story['url'] . '">' . $story['title'] . '</a> and said:<br />' . $story['commentary'] . '<br />';
	foreach($comments as $col => $val){
		echo 'User ' . $val['user_name'] . ' says:<br />';
		echo '<p>'. $val['comment'] . '</p><br />';
	}
?>

<h2> Submit a comment </h2>
<form action="includes/post_comment.php" method="post">
  comment:<br>
  <input type="text" name="comment">
  <br>
  <input type="submit" value="post!">
</form>

</body>
</html>
