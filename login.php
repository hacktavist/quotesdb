<?php
require("encryption.php");
require("config.inc.php");

if(!empty($_POST)){
    if(empty($_POST['username']) || empty($_POST['password'])) {
        $response['success'] = 0;
        $response['message'] = "What a terrible failure...Please enter both a username and password";
        die(json_encode($response));
    }
	$query = "Select id, username, password From Users Where username = :username";
    
	$query_params = array(':username' => $_POST['username']);
 
    try{
        $stmt = $db->prepare($query);
        $results = $stmt->execute($query_params);
    }
    catch(PDOException $ex){
        $response['success'] = 0;
        $response['message'] = "What a terrible failure...Database error 93425.";
        die(json_encode($response));
    }

    $validated_info = false;

    $row = $stmt->fetch();
    if($row){
        $password_hash = generateHash($_POST['password'], $row['password']);
    	if($password_hash === $row['password']){
    		$ok_login = true;
    	}
    }

    if($ok_login){
    	$response['success'] = 1;
    	$response['message'] = "Login Successful!";
   		die(json_encode($response));
    }
    else{
    	$response['success'] = 0;
    	$response['message'] = "Login Failure!";
    	die(json_encode($response));
    }
} else{
?>
<h1>Login</h1>
<form action="login.php" method="post">
  Username: <br/>
  <input type="text" name="username" value="" />
  <br/>
  Password: <br/>
  <input type="password" name="password" value= ""/>
  <br/><br/>
  <input type="submit" value="Login" />
</form>
<?php
}
?>