<?php
require "config.php";
require "functions.php";
session_start();
if(!isset($_SESSION['username'])){
	header("Location: index.php");
}
$commenter_id = $_SESSION['uid'];
$story_id = $_GET['id'];
$comment = $_POST['comment'];

$stmt = $mysqli->prepare("insert into comments (commenter_id, story_id, comment) values (?, ?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

 $stmt->bind_param('iis', $commenter_id, $story_id, $comment);
 $stmt->execute();
 $stmt->close();

header("Location: ../story.php?id=" . $story_id);


?>
