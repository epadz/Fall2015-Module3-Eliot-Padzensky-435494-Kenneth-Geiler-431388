<?php
require 'includes/config.php';
require 'includes/functions.php';
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php?error=4");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
	<?php
        echo $_SESSION['uid'] . '<br />';
        echo $_SESSION['username'] . '<br />';
        echo $_SESSION['fname'] . '<br />';
        echo $_SESSION['lname'] . '<br />';
    
    ?>
    <br>
    <a href="includes/logout.php">logout</a>
    <br>
    <form action="includes/post_story.php" method="post">
      title:<br>
      <input type="text" name="title">
      <br>
      url:<br>
      <input type="text" name="url">
      <br>
      commentary: <br>
      <input type="text" name="commentary">
      <input type="hidden" name="poster_id">
      <input type="submit" value="post!">
    </form>
    <table id="stories">
    	<tr>
        	<td>Link</td>
            <td>Commentaty</td>
            <td></td>
            <td>Current Vote</td>
            <td></td>
            <td></td>
        </tr>
    <?php
        $stories = query();
        foreach($stories as $key => $value){
            echo '<tr>
			<td><a href="' . htmlspecialchars( $value["url"] ) . '">' . htmlspecialchars( $value["title"] ) . '</a></td>
			<td>' . htmlspecialchars( $value["commentary"] ) . '</td>
			<td><a href="story.php?id=' . htmlspecialchars( $value["story_id"] ) . '">comments</a></td>
			<td>' . $value["vote"] . '</td>
			<td><a href="includes/upvote.php?id=' . htmlspecialchars( $value["story_id"] ) . '">upvote</a></td>
			<td><a href="includes/downvote.php?id=' . htmlspecialchars( $value["story_id"] ) . '">downvote</a></td>
			</tr>';
        }     
    ?>
    </table>
</body>
</html>
