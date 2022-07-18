<?php
require "connect.php";
if( isset($_SESSION['user'])) {
    $user = json_decode($_SESSION['user']);
    if ( isset($_REQUEST['title']) && isset($_REQUEST['phone']) 
        && empty(isset($_REQUEST['name_field'])) && empty(isset($_REQUEST['value_field'])) ) {
        $title = $_REQUEST["title"];
        $phone = $_REQUEST["phone"];
        $id = 0;
        $getMaxId = $userPhoneBook->find(
        [],
        [
            'limit' => 1,
            'sort'  => [ '_id' => -1 ],
            'projection' => [ '_id' => 1]
        ]);
        foreach ($getMaxId as $document) {
            $id = $document{'_id'};
            print_r($id); echo '<br>';
        }

        $addNewRecord = $userPhoneBook->insertOne(
            [
                '_id' => ++$id,
                'userName' => $user->Name,
                'userEmail' => $user->Email,
                'title' => $title,
                'phone' => $phone  
            ]);

    }
    else {
        $title = $_REQUEST["title"];
        $phone = $_REQUEST["phone"];        
        $names_of_fields = $_REQUEST['name_field'];
        // $names_of_fields = implode(" ",$names_of_fields);
        //echo $names_of_fields."<br>";
        $values_of_fields = $_REQUEST['value_field'];
        // $values_of_fields = implode(" ",$values_of_fields);
        //echo $values_of_fields."<br>";
        $id = 0;
        $getMaxId = $userPhoneBook->find(
        [],
        [
            'limit' => 1,
            'sort'  => [ '_id' => -1 ],
            'projection' => [ '_id' => 1]
        ]);
        foreach ($getMaxId as $document) {
            $id = $document{'_id'};
            print_r($id); echo '<br>';
        }

        $addNewRecord = $userPhoneBook->insertOne(
            [
                '_id' => ++$id,
                'userName' => $user->Name,
                'userEmail' => $user->Email,
                'title' => $title,
                'phone' => $phone  
            ]);

            for( $i = 0; $i < count($names_of_fields); $i++) {
                $addNewRecord = $userPhoneBook->updateOne(
                    [
                        '_id' => $id,
                        'userName' => $user->Name,
                        'userEmail' => $user->Email,
                        'title' => $title,
                        'phone' => $phone  
                    ],           
                    [
                        '$set' => [ $names_of_fields[$i] => $values_of_fields[$i] ]
                    ]
                );
            }     
    }
    header('Location:phoneBook.php');
}

?>  