<?php
require "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация/авторизация пользователя</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon">
</head>
<body>
    <div class="title">Phone Book</div> 
    <?php if( isset($_SESSION['user']) ) : ?>
    <?php header('Location:phoneBook.php'); ?>
    <?php else : ?>
    <a href="registration.php" ><input type="button" class="button" value="Зарегестрироваться"/></a>
    <br>
    <a href="authorization.php" ><input type="button" class="button" value="Войти"/></a>  
    <?php endif; ?>
</body>
</html>

