<?php
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
</body>
</html>