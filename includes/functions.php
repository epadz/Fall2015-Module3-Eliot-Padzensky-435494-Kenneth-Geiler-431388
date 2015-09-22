<?php
require_once "config.php";

//echo isUser('userGuy');
//checks whether a given username exists
//$u is username
function isUser($u){
	global $mysqli;
	$stmt = $mysqli->prepare("select user_name from users where user_name=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $u);
	$stmt->execute();
	$stmt->store_result();
    $num = $stmt->num_rows;
	$stmt->close();
	return ($num == 1);
}
//checks a log in
//parameters are username and password
//returns if login is correct, it returns an associative array of the users information including id, first name, last name and username. If login fails, NULL is returned
function checkLogin($username, $password){
	global $mysqli;
	$stmt = $mysqli->prepare("select * from users where user_name=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($qid, $qfn, $qln, $qun, $qpw);
	$stmt->store_result();
	
	$stmt->fetch();
		
	$isValid = false;
    if($stmt->num_rows == 1){
		$isValid = 	crypt($password, $qpw)==$qpw;
		//echo $isValid;
	}
	$stmt->close();
	
	if($isValid){
		$results = array(
			"uid" => $qid,
			"fn" => $qfn,
			"ln" => $qln,
			"un" => $qun,
		);
		return $results;
	}
	return NULL;
}

//logs out
function logout(){
	session_start();
	session_unset(); 
	session_destroy();
}
?>