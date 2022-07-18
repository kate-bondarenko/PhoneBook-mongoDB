<?php
require "connect.php";
if( isset($_SESSION['user'])) {
    $user = json_decode($_SESSION['user']);
    if (isset($_REQUEST['filter']) && ! empty($_REQUEST['filter'])) {
        $filter = $_REQUEST['filter'];
        $userRecords = $userPhoneBook->find(
            [
                'userName' => $user->Name,
                'userEmail' => $user->Email,
            ],
            [
                'projection' => [$filter => 1]
            ]);        
            $count = $userPhoneBook->count(array('userName' => $user->Name, 'userEmail' => $user->Email));
            //echo $count;
            $counter = 0;
            echo '[';
            foreach ($userRecords as $res)
            {
                echo json_encode($res);
                if($counter != $count-1) {
                    echo ','; 
                }
                $counter++;
            }
            echo ']'; 
    }
}
?>