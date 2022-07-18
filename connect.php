<?php
error_reporting(E_ALL);
require_once __DIR__ . "/vendor/autoload.php";
try {
    $dataUsers = (new MongoDB\Client)->phoneBook->users;
    $userPhoneBook = (new MongoDB\Client)->phoneBook->UsersPhoneBook;
    
} catch (Exception $ex) {
    echo $ex->GetMessage();
}
session_start();    

?>