<?php
require 'config.php';
require 'functions.php';
session_start();
if(!isset($_SESSION['username'])){
	header("Location: ../index.php?error=1");
	exit;
}
if(!isset($_GET['id'])){
	header("Location: ../index.php");
	exit;
}
$story_ID = $_GET['id'];
downvote($story_ID);
header("Location: ../index.php");
?>