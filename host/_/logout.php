<?php 
session_start();
//logout
unset($_SESSION['user_id']);


//logged in return to index page
header('Location: login.php');
exit;
?>