<?php
//include config
require_once('../config.php');

//check if already logged in move to home page
//if( $user->is_logged_in() ){ header('Location: index.php'); } 

//process login form if submitted
if(isset($_POST['submit'])){

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(isset($username)){ 
	       //$stmt = $db->prepare('SELECT * FROM tbl_admin WHERE user_name = :username AND password = :password AND id=1 ');
		   $stmt = $db->prepare('SELECT * FROM admin WHERE username = :username AND password = :password');
			$stmt->execute(array('username' => $username, 'password' => $password));
		  // $stmt->debugDumpParams();
			$row = $stmt->fetch();
			if($stmt->rowCount()==1){
				$_SESSION['adminuser'] = $username;
				$_SESSION['admin']  = 'admin';
				$_SESSION['id']=$row['id'];
				$user_id=$row['id'];
					
					header('Location: index.php');
				exit;
			}else{
				$error[] = 'Wrong username or password.';
				}
	
	} else {
		$error[] = 'Wrong username or password or your account has not been activated.';
	}

}//end if submit

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="assets/css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	<style>
@media (min-width:768px) and (max-width: 1368px)
{
	.login-wrapper{ margin-top:25%;}
}
@media (min-width: 1368px)
{
	.login-wrapper{ margin-top:50%;}
}
	</style>
  </head>
  <body class="login-bg">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo">
	                 <a href="index.php"><img src="images/mylogo.png" height="100px" alt="SMA"></a>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
                        <form role="form" method="post" action="" autocomplete="off">
			                <h6>Sign In</h6>
			                <?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="alert alert-danger">'.$error.'</p>';
					}
				}

				if(isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='alert alert-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='alert alert-success'>Please check your inbox for a reset link.</h2>";
							break;
						case 'resetAccount':
							echo "<h2 class='alert alert-success'>Password changed, you may now login.</h2>";
							break;
					}

				}

				
				?>
			                <input class="form-control" type="text" name="username" id="username"  placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
			                <input class="form-control" type="password"  name="password" id="password" placeholder="Password" tabindex="2">
			                <div class="action">
                            <input type="submit" name="submit" value="Login" class="btn btn-primary signup" tabindex="3">
			                </div> 
                            <div class="row">
					
				</div> 
                            </form>              
			            </div>
			        </div>

			      
			    </div>
			</div>
		</div>
	</div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>
  </body>
</html>