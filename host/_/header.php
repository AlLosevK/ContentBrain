<?php 
require('dbfunction.php'); 
if(!isset($_SESSION['user_id'])){
	header('Location: login.php');
	exit;
}

if(isset($_GET['cid']))
{
	$cid=$_GET['cid'];
	$coretopic=get_coretopic($cid);	
	$project_name=$coretopic[0];
	$topic_name=$coretopic[1];
	$pid=$coretopic[2];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php if(isset($title)){ echo $title; }else { echo "ContentBrain"; } ?>
    </title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/messi.css">
    <link rel="stylesheet" href="css/media.css">
</head>

<body class="container-body">
    <header class="header container-header">
        <div class="container container-wrap">
            <a class="home" href="index.php">
          </a>
            <?php include("menu.php");?>
            <div class="logo">
                <h1 class="logo__title-header">content brain </h1>
                <img src="img/logo.png" alt="Logo" class="logo__img">
            </div>
            <div class="setting">
                <a href="accountSettings.php">account settings</a>
            </div>
        </div>
    </header>
