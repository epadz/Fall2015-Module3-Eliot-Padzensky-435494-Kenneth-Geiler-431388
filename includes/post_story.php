<?php
require "config.php";
require "functions.php";
session_start();
if(!isset($_SESSION['username'])){
	header("Location: index.php");
}
$title = $_POST['title'];
$url = $_POST['url'];
$commentary = $_POST['commentary'];
$poster_id = $_SESSION['uid'];


$stmt = $mysqli->prepare("insert into stories (title, url, commentary, poster_id) values (?, ?, ?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

 $stmt->bind_param('ssss', $title, $url, $commentary, $poster_id);
 $stmt->execute();
 $stmt->close();

header("Location: ../index.php");



?>
