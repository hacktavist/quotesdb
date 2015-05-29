<?php

require("encryption.php");
require("config.inc.php");

if(!empty($_POST)){
    if(empty($_POST['username']) || empty($_POST['password'])) {
        $response['success'] = 0;
        $response['message'] = "What a terrible failure...Please enter both a username and password";
        die(json_encode($response));
    }

    $query = "Select 1 From Users Where Username = :user";
    $query_params = array(':user' => $_POST['username']);

    try{
        $stmt = $db->prepare($query);
        $results = $stmt->execute($query_params);
    }
    catch(PDOException $ex){
        $response['success'] = 0;
        $response['message'] = "What a terrible failure...Database error 93425.";
        die(json_encode($response));
    }

    $row = $stmt->fetch();
    if($row){
        $response['success'] = 0;
        $response['message'] = "What a terrible failure...This username is already in use.";
        die(json_encode($response));
    }

    $password_hash = generateHash($_POST['password']);

    $query = "Insert Into Users (username, password) Values(:user, :pass)";

    $query_params = array(':user' => $_POST['username'],
                          ':pass' => $password_hash);
    try{
        $stmt = $db->prepare($query);
        $results = $stmt->execute($query_params);
    }
    catch(PDOException $ex){
        $response['success'] = 0;
        $response['message'] = "What a terrible failure...Database error 84759.";
        die(json_encode($response));
    }

    $response['success']=1;
    $response['message']="User successfully created!";
    echo json_encode($response);




}else{
?>

<h1>Register</h1>
<form action="register.php" method="post">
    Username: <br/>
    <input type="text" name="username" value="" />
    <br/>
    Password: <br/>
    <input type="password" name="password" value="" />
    <br/>
    <br/>
    <input type="submit" value="Register" />
</form>
<?php
}
?>