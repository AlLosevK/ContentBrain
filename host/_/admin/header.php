<?php include('../config.php');

//if logged in redirect to members page
if($_SESSION['admin']!='admin' || empty($_SESSION['adminuser'])) { header('Location: login.php'); } 

?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php if(isset($title)){ echo $title; }else { echo "SMA"; } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="assets/css/styles.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="header">
	     <div class="container">
	        <div class="row">
			
	           <div class="col-md-8">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1 class="logo__title-header">content brain </h1>
					 <img src="images/logo.png" class="logo__img" alt="SMA">
	              </div>
	           </div>
	           <div class="col-md-4"> 
	              
	           </div>
	           <div class="col-md-3">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                         <!-- <li><a href="profile.php">Profile</a></li>-->
							 <li><a href="change_password.php">Change Password</a></li>
	                          <li><a href="logout.php">Logout</a></li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>