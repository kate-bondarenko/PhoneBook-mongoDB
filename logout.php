<?php
require "connect.php";
unset($_SESSION['user']);
header('Location:main.php');

?>