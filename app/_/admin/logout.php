<?php 
session_start();
//logout
unset($_SESSION['adminuser']);
unset($_SESSION['admin']);

				
//logged in return to index page
header('Location: login.php');
exit;
?>