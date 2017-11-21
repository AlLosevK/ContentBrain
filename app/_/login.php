<?php
//include config
require_once('config.php');

//check if already logged in move to home page
//if( $user->is_logged_in() ){ header('Location: index.php'); } 

//process login form if submitted
if(isset($_POST['submit'])){

	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if(isset($email)){ 
	       //$stmt = $db->prepare('SELECT * FROM tbl_admin WHERE user_name = :username AND password = :password AND id=1 ');
		   $stmt = $db->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
			$stmt->execute(array('email' => $email, 'password' => $password));
		  // $stmt->debugDumpParams();
			$row = $stmt->fetch();
			if($stmt->rowCount()==1){
				$_SESSION['user_id']=$row['id'];
					
					header('Location: index.php');
				exit;
			}else{
				$error[] = 'Wrong email or password.';
				}
	
	} else {
		$error[] = 'Wrong email or password or your account has not been activated.';
	}

}//end if submit

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - ContentBrain</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
</head>

<body class="container-body">
    <header class="header container-header">
        <div class="container container-wrap">
            <div class="navigation">
                <span class="navigation__title">login</span>
            </div>
            <div class="logo">
                <h1 class="logo__title-header">content brain </h1>
                <img src="img/logo.png" alt="Logo" class="logo__img">
            </div>
            <div class="setting">
               <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12px" height="16px"><path fill-rule="evenodd"  fill="rgb(214, 141, 255)"
 d="M5.374,-0.000 C8.890,-0.066 10.936,3.179 8.845,5.943 C8.126,6.893 5.809,7.642 4.269,6.857 C3.362,6.395 2.688,5.558 2.376,4.724 C2.121,2.925 2.505,1.454 3.796,0.609 C4.142,0.383 4.465,0.417 4.743,0.152 C5.114,0.129 5.188,0.138 5.374,-0.000 ZM12.000,16.000 C8.004,16.000 4.006,16.000 0.010,16.000 C0.024,15.704 -0.016,15.636 0.010,15.238 C-0.017,14.561 0.068,13.524 0.325,12.800 C0.840,11.350 1.891,9.877 3.165,9.143 C3.909,8.714 5.494,8.498 6.320,8.686 C6.899,8.736 7.477,8.787 8.056,8.838 C10.588,9.778 12.048,12.565 12.000,16.000 Z"/>
</svg>
                <span>request access</span>
            </div>
        </div>
    </header>
    <main class="container entry">
        <div class="container-coll">
            <h2 class="main__tittle">welcome</h2>
			<?php
			//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="alert alert-danger">'.$error.'</p>';
					}
				}
			?>	
            <form class="login container-coll" name="login" method="post">
                <div class="pseudo pseudo-email">
                    <input type="email" name="email" class="login__email login__item" placeholder="email" autofocus required>
                </div>
                <div class="pseudo pseudo-pass">
                    <input type="password" name="password" class="login__pass login__item" placeholder="password" required>
                </div>
                <button type="submit" name="submit" class="login__check login__item">GO</button>
            </form>
        </div>
    </main>
  <?php include('footer.php');?>
       
</body>

</html>