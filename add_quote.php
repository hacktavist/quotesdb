<?php
require("config.inc.php");

if(!empty($_POST)){

	$query = "Insert into Quotes (quote_type, username, quote) Values(:quote_type, :user, :quote)";

	$query_params = array(':quote_type' => $_POST['quote_type'],
											':user' => $_POST['username'],
		                  ':quote' => $_POST['quote']);

	try{
		$stmt = $db->prepare($query);
		$reulsts = $stmt->execute($query_params);
	}
	catch(PDOException $ex){
		$response['success'] = 0;
		$response['message'] = "What a terrible failure...Database error 753951.";
		die(json_encode($response));
	}
	$response['success'] = 1;
	$response['message'] = "Added quote successfully!";
	die(json_encode($response));

} else{
?>

<h1>Add Quote</h1>
<form action="add_quote.php" method="post">
	<select name="quote_type">
		<option value="default">Select an Item</option>
		<option value="comic">Comical</option>
		<option value="intelligent">Intelligent</option>
		<option value="other">Other</option>
	</select>
	<br/><br/>
	Username: <br/>
	<input type="text" name="username" value="" />
	<br/>
	Quote: <br/>
	<textarea rows="4" cols="50" name="quote"></textarea>
	<br/>
	<br/>
	<input type="submit" value="Add Quote" />
</form>
<?php
}
?>