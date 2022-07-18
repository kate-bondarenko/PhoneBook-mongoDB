<?php
require "connect.php";
if( isset($_SESSION['user'])) {
    $user = json_decode($_SESSION['user']);
    $id = (int)$_REQUEST['_id'];
    if (isset($_REQUEST['editName']) && !empty($_REQUEST['editName']) && 
        isset($_REQUEST['editNewValue']) && !empty($_REQUEST['editNewValue'])) {
        $editName = $_REQUEST['editName'];
        $editNewValue = $_REQUEST['editNewValue'];
        $addNewRecord = $userPhoneBook->updateOne(
        [
            '_id' => $id,
            'userName' => $user->Name,
            'userEmail' => $user->Email
        ],           
        [
            '$set' => [ $editName => $editNewValue ]
        ]);
        echo 1;
    }
    else {
        echo 0;
    } 
}

?>