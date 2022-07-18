<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css">
<title>Aвторизация пользователя</title>
</head>
<body>
<div class="title">Authorization</div>
<form id="form-authorization" action="authorization.php" method="post">
<p>Input your email:</p>
    <p><input class="input" id="authEmail" name="authEmail" type="email" maxlength=50 placeholder="example@gmail.com"
    value="<?php echo @$_REQUEST["authEmail"]?>"></p>
    <p>Input your password:</p>
    <p><input class="input" id="authPswd" name="authPswd" type="password" maxlength=50></p>
    <p><input class="button" type="submit" name="authButton"/></p>
</form>
</body>
</html>
<?php
require "connect.php";
if ($_SERVER['REQUEST_METHOD'] == "POST" ){
    if ( isset($_REQUEST['authButton']) ) {
        $authEmail = $_REQUEST["authEmail"];
        $authPassword = $_REQUEST["authPswd"];
        $errors = array();

        $userEmailExist = $dataUsers->findOne(array('Email' => $authEmail));
        //print_r($userEmailExist);
       
        if( empty($authEmail) || empty($authPassword) ) { 
            $errors[] = "Вы не заполнили все поля. Введите данные";
            echo '<div style="color: red;">'.array_shift($errors).'</div>';
            echo '<br>';
        }
        
        if($userEmailExist == null) {
            $errors[] = 'Пользователь с таким Email не существует!';
        }
        else {
            //echo 'Email существует';
            if( password_verify($_REQUEST["authPswd"], $userEmailExist['password']) ) {
                $_SESSION['user'] = json_encode($userEmailExist);
                header('Location:phoneBook.php');
                //echo 'Пароль совпадает';               
            }
            else {
                $errors[] = 'Неверно введён пароль!'; 
            }
        }
        if( !empty($errors) ) {
            echo '<div style="color: red;">'.array_shift($errors).'</div>';
        }
    }
}
?>  

