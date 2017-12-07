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
                <div class="setting setting-access">
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
