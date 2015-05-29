<?php
require("config.inc.php");
if(!empty($_POST)){
  $query = "Delete From Quotes Where username = username";
  try{
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params);
  }
  catch(PDOException $ex){
    $response['success'] = 0;
    $response['message'] = "You cannot delete a quote that is not yours!";
    die(json_encode($response));
  }
}
?>