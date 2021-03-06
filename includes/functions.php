<?php
require_once "config.php";
//returns an array of stories with data
function query(){
	global $mysqli;
	$stmt = $mysqli->prepare("select count(comments.comment_id) as comments_num, stories.*, users.user_name from stories left join comments on (comments.story_id = stories.story_id) join users on (users.user_id = stories.poster_id) group by stories.story_id order by stories.vote desc");
	if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
	}
	
	
	$stmt->execute();
	
	$result = $stmt->get_result();
	$stories = array();
	while($row = $result->fetch_assoc()){
			array_push($stories, $row);	
	}	
	$stmt->close();
	return $stories;
}

//returns a specific story
//id is story id

function getStory($id){
	global $mysqli;
	$stmt = $mysqli->prepare("select stories.*, users.user_name, count(comments.comment_id) as comments_num from stories join users on (stories.poster_id = users.user_id) left join comments on (stories.story_id = comments.story_id) where stories.story_id=? group by stories.story_id");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$story = $result->fetch_assoc();
	$stmt->close();	
	return $story;
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
//gets a comment
//id is the comment id
//returns an array with comment data
function getComment($id){
	global $mysqli;
	$stmt = $mysqli->prepare("select * from comments where comment_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$comment = $result->fetch_assoc();
	$stmt->close();	
	return $comment;
}
//downvotes a story
//id is story id
function downvote($id){
	global $mysqli;
	$stmt = $mysqli->prepare("update stories set vote = vote - 1 where story_id = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();	
}
//upvotes a story
//id is story id
function upvote($id){
	global $mysqli;
	$stmt = $mysqli->prepare("update stories set vote = vote + 1 where story_id = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();
}
//deletes a story
//id is story id
function deleteStory($id){
	global $mysqli;
	$stmt = $mysqli->prepare("delete from stories where story_id = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();
}
//deletes a comment
//id is story id
function deleteComment($id){
	global $mysqli;
	$stmt = $mysqli->prepare("delete from comments where comment_id = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();
}
//updates a story
//id is story id
//content is new content
function updateStory($id, $content){
	
}
//updates a comment
//id is story id
//content is new content
function updateComment($id, $content){
	
}
?>
