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

<?php 
$stmt = $mysqli->prepare("select title, url, poster_id, commentary from stories");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
 
$stmt->execute();
 
$result = $stmt->get_result();
 
echo "<ul>\n";
while($row = $result->fetch_assoc()){
	printf("\t<li>%s %s</li>\n",
		htmlspecialchars( $row["title"] ),
		htmlspecialchars( $row["url"] ),
		htmlspecialchars( $row["commentary"] )
	);
	$pid = $row['poster_id'];
	echo '<a href="story.php?id='. $pid .'" >Check out the article</a>';

}
echo "</ul>\n";
 
$stmt->close();
?>

</body>
</html>
