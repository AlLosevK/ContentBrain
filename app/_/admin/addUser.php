<?php
require('config.php');
require('web_service/function.php');
//if logged in redirect to members page
if($_SESSION['admin']!='admin' || empty($_SESSION['adminuser'])) { header('Location: login.php'); }  
$title = "Add Client";

?>

<?php
if(isset($_POST['submit'])){ //die("dd");
	try {
	
		$profile_image = $_FILES['profile_image']['name'];
		$profile_image_tmp_dir = $_FILES['profile_image']['tmp_name'];
		$profile_image_size = $_FILES['profile_image']['size'];
		//header("Location: userinfo.php");
		if($profile_image)
		{
			$upload_dir = 'web_service/images/'; // upload directory	
			$imgExt = strtolower(pathinfo($profile_image,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$pro_image = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($profile_image_size < 5000000)
				{
					unlink($upload_dir.$row['profile_image']);
					move_uploaded_file($profile_image_tmp_dir,$upload_dir.$pro_image);
					$urlWithProImage=DIR."web_service/images/".$pro_image;
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else{
			$urlWithProImage="";
		}
		
		
			$date=date('Y-m-d h:i A');
				//exit;
				//insert into database with a prepared statement
				$stmt = $db->prepare("INSERT INTO `table_users`(`profile_image`, `name`, `email`, `password`, `gender`, `address`, `city`, `phone_number`,`created_date`,`modify_date`) VALUES (:profile_image, :name, :email, :password, :gender, :address, :city, :phone_number, :created_date,:modify_date)");
				//print_r("hello");exit;
				$stmt->execute(array(
					':password' => $_POST['password'],
					':email' => $_POST['email'],
					':phone_number' => $_POST['phone_number'],
					':profile_image' =>$urlWithProImage,
					':gender' => $_POST['gender'],
					':city' => $_POST['city'],
					':address' => $_POST['address'],
					':name' => $_POST['name'],
					':created_date' => $date,
					':modify_date' => $date,
					
				));
				
		 	/* Check Additional field for Mail */
		    
			if($_POST['name'] != "")
			{
				$message .= "Name : ".$_POST['name']."<br/>";
			}
			if($_POST['phone_number']!= "")
			{
				$message .= "Phone Number : ".$_POST['phone_number']."<br/>";
			}
			if($_POST['gender'] != "")
			{
				$message .= "Gender : ".$_POST['gender']."<br/>";
			}
			if($_POST['city'] != "")
			{
				$message .= "City : ".$_POST['city']."<br/>";
			}
			if($_POST['address'] != "")
			{
				$message .= "Address : ".$_POST['address']."<br/>";
			}
			 if($urlWithProImage != "")
			{
				$message .= "Profile Image :  <img alt='Profile Image' src='".$urlWithProImage."' style='max-width:100px;width:100%;height:auto;border:0;outline:0' tabindex='0' width='100%' height='auto'><br/>";
			}
			/* End Add field for Mail */
			/* Mail */
				$name= $_POST['name'];
				$email=$_POST['email'];
				$mail_msg ='Your account for <strong style="font-size:16px;margin:0;color:#fff;line-height:18px">The Little Things Company</strong> mobile service was created successfully by Assistent.<br/><br/> Your Login Credential :<br/> Email : <strong style="font-size:16px;margin:0;color:#fff;line-height:18px">'.$_POST['email'].'</strong><br/> Password : <strong style="font-size:16px;margin:0;color:#fff;line-height:18px">'.$_POST['password'].'</strong><br/><br/> Additional Information :<br/>'.$message;
				sendNotification($email,"Littlething Account Created",$mail_msg,$name);
								
				$msg = "Client's successfully registered";	
			/* end mail */
			
			//else catch the exception and show the error.
			
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

}

?>
<?php include("header.php"); ?>

<div class="container">
    <div class="page-content leftdetails">
    	<div class="row">
		  <div class="col-md-2">
		  	<?php include("left_navigation.php"); ?>
		  </div>
          
          <div class="col-md-10">
		  	<div class="row">
		  		
				<!-- breadcrumb-->
				 <div class="col-md-12 btn-group btn-breadcrumb">
					<span class="btn btn-default"><a href="index.php"><i class="glyphicon glyphicon-home"></i></a></span>
					<span class="btn btn-default"><a href="clientinfo.php">Clients</a></span>
					<span class="btn btn-default active">Add Client</span>
				</div>
			   <!-- close breadcrumbs -->
			   
                 <div class="col-md-12 panel-info">	
				 <div class="content-box-header panel-heading" style="height:55px !important;">
					<div class="panel-title ">Adding New Client</div>
					<div class="panel-options"> 
					
				  </div>
				  </div>
				<div class="content-box-large box-with-header">
					<div class="row">
                     <div class="col-md-12">
						<div class="col-md-9">
			
                 
                  <?php if(isset($msg)){ echo '<p class="alert alert-success">'.$msg.'</p>'; }?>
				  <?php if(isset($error)){ echo '<p class="alert alert-danger">'.$error.'</p>'; }?>
              <form role="form" method="post" action="" class="form-horizontal" autocomplete="off" id="add_profile" enctype="multipart/form-data">
			               
                
                  	<div class="form-group">
                    <label class="control-label col-sm-2" for="User Name">Name <span class="required">*</span> : </label>
                    <div class="col-sm-10">
                       <input type="text" name="name" id="name" class="form-control"  value="">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="Password">Password <span class="required">*</span> : </label>
                    <div class="col-sm-10">
                       <input type="password" name="password" id="password" class="form-control"  value="" >
                    </div>
                  </div>                  
                  
                  	<div class="form-group">
                    <label class="control-label col-sm-2" for="E-mail Address">E-mail <span class="required">*</span> : </label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="email" id="email" value="">
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="phone_number">Phone Number <span class="required">*</span> : </label>
                    <div class="col-sm-10">
                      <input type="text" name="phone_number" id="phone_number" class="form-control"  value="" >
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="Profile Image">Profile Image : </label>
                    <div class="col-sm-10">
                       <input type="file" name="profile_image" class="btn btn-primary" accept="image/*" />
                    </div>
                  </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="Gender">Gender : </label>
                    <div class="col-sm-10">
                    <div class="radio">
                    <label><input type="radio" name="gender" value="male" checked>Male</label>
                    </div>
                    <div class="radio">
                    <label><input type="radio" name="gender" value="female">Female</label>
                    </div></div></div>
                    
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="city">City : </label>
                    <div class="col-sm-10">
                      <input type="text" name="city" id="city" class="form-control"  value="" >
                    </div>
                  </div>

				 <div class="form-group">
                    <label class="control-label col-sm-2" for="address">Address : </label>
                    <div class="col-sm-10">
                      <input type="text" name="address" id="address" class="form-control"  value="" >
                    </div>
                  </div>
                    
               

                    <div class="action">
                         <input type="submit" name="submit" value="Add Now" class="btn btn-primary signup" tabindex="5">                         
			        </div> 
                </form>   
  					</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
	</div>
  </div>
 </div>


<?php include("footer.php"); ?>

