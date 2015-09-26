<?php
require 'config.php';
require 'functions.php';
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php?error=4");
}
if(!isset($_GET['id'])){
	header("Location: index.php");
}
$story_ID = $_GET['id'];
upvote($story_ID);
header("Location: ../index.php");
?>