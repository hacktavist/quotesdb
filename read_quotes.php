<?php
require("config.inc.php");
$query = "Select * From Quotes";
try{
	$stmt = $db->prepare($query);
	$result = $stmt->execute($query_params);
}
catch(PDOException $ex){
	$response['success'] = 0;
	$response['message'] = "What a terrible failure...Database error 675159.";
	die(json_encode($response));
}
$rows = $stmt->fetchAll();
if($rows){
	$response['success'] = 1;
	$response['message'] = "Quote(s) available!";
	$response['posts'] = array();

	foreach($rows as $row){
		$post = array();
		$post['post_id'] = $row['post_id'];
		$post['username'] = $row['username'];
		$post['quote'] = $row['quote'];
		$post['created_at'] = $row['created_at'];

		array_push($response['posts'], $post);
	}

	echo json_encode($response);
} else{
	$response['success'] = 0;
	$response['message'] = "No quotes available!";
	die(json_encode($response));
}
?>