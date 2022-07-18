<?php
require "connect.php";
if( isset($_SESSION['user'])) {
    $user = json_decode($_SESSION['user']);
    $id = (int)$_REQUEST['_id'];
    echo $id;
    $removeRecord = $userPhoneBook->deleteOne(['_id' => $id]);    
}

?>