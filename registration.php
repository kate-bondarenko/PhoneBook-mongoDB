<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css">
<title>Регистрация пользователя</title>
</head>
<body>
    <div class="title">Registration</div>
<form id="form-registration" action="registration.php" method="post">
    <p>Input your name:</p>
    <p><input class="input" id="regName" name="regName" type="text" maxlength=50 placeholder="Ivan Ivanov"></p>
    <p>Input your email:</p>
    <p><input class="input" id="regEmail" name="regEmail" type="email" maxlength=50 placeholder="example@gmail.com" ></p>
    <p>Input your password:</p>
    <p><input class="input" id="regPswd" name="regPswd" type="password" maxlength=50></p>
    <p>Repeat your password:</p>
    <p><input class="input" id="regPswd2" name="regPswd2" type="password" maxlength=50></p>
    <p><input class="button" type="submit" name="regButton"/></p>
</form>
</body>
</html>
<?php
require "connect.php";
if ($_SERVER['REQUEST_METHOD'] == "POST" ){
    if ( isset($_REQUEST['regButton']) ) {
        $regName = $_REQUEST["regName"];
        $regEmail = $_REQUEST["regEmail"];
        $regPassword = $_REQUEST["regPswd"];
        $regPassword2 = $_REQUEST["regPswd2"];
        $errors = array();

        $countSameUsersName = $dataUsers->count(array('Name' => $regName));
        //echo $countSameUsersName;
        $countSameUsersEmail = $dataUsers->count(array('Email' => $regEmail));
        //echo $countSameUsersName;
       
        if( empty($regName) && empty($regEmail) && empty($regPassword) 
            && empty($regPassword2)) { 
            $errors[] = "Вы не заполнили поля. Введите данные";
            echo '<div style="color: red;">'.array_shift($errors).'</div>';
            echo '<br>';
        }
        else if ( trim($regName) == '') {
            $errors[] = "Введите логин!";
        } 
        else if ( trim($regEmail) == '') {
            $errors[] = "Введите Email!";
        } 
        else if ($regPassword == '' && $regPassword2 == '') {
            $errors[] = "Введите пароль!";
        } 
        else if($regPassword != $regPassword2) {
            $errors[] = "Повторный пароль введен неверно!";
        }
        else if($countSameUsersName > 0) {
            $errors[] = "Пользователь с таким именем уже существует!";
        }
        else if($countSameUsersEmail > 0) {
            $errors[] = "Пользователь с таким Email уже существует!";
        }
        else {
            //echo '<div style="color: green;">Вы успешно зарегестрированны</div>'; 
            $insertUser = $dataUsers->insertOne(
            ['Name' => $regName,
            'Email' => $regEmail,
            'password' => password_hash($regPassword, PASSWORD_DEFAULT)
            ]);
            header('Location:main.php');
        }
        if( !empty($errors) ) {
            echo '<div style="color: red;">'.array_shift($errors).'</div>';
        }
    }
}

?>  

