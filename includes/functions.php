<?php
require_once "config.php";

function query(){
global $mysqli;
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
}


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

//gets comments for a story data
//id is story id
//returns an array of comments
function getComments($id){
	global $mysqli;
	$stmt = $mysqli->prepare("select comment_id, commenter_id, comments.story_id, comment, users.user_id, users.user_name, users.first_name, users.last_name from comments join users on (comments.commenter_id = users.user_id) where comments.story_id = ? order by comment_id asc");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $id);
	$stmt->execute();
	
	$comments = array();
	$result = $stmt->get_result();
	while($row = $result->fetch_assoc()){
		array_push($comments, $row);
	}	 
	$stmt->close();	
	return $comments;
}
?>
