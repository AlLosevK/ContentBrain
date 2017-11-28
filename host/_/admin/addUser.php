<?php
require('../config.php');
//if logged in redirect to members page
if($_SESSION['admin']!='admin' || empty($_SESSION['adminuser'])) { header('Location: login.php'); }  
$title = "Add User";

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
			$upload_dir = '../images/'; // upload directory	
			$imgExt = strtolower(pathinfo($profile_image,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$pro_image = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($profile_image_size < 5000000)
				{
					move_uploaded_file($profile_image_tmp_dir,$upload_dir.$pro_image);
					$urlWithProImage=DIR."images/".$pro_image;
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
			$stmt = $db->prepare("INSERT INTO `users`(`url`, `name`, `email`, `password`, `profile_image`, `status`, `created_date`, `modified_date`) VALUES (:url,:name,:email,:password,:profile_image,:status,:created_date,:modified_date)");
				//print_r("hello");exit;
				$stmt->execute(array(
					':url' => $_POST['url'],
					':name' => $_POST['name'],
					':email' => $_POST['email'],
					':password' =>$_POST['password'],
					':profile_image' => $urlWithProImage,
					':status' => 1,
					':created_date' => $date,
					':modified_date' => $date,
				));
				
				
		 	$msg = "User's successfully registered";	
			/* end mail */
			
			//else catch the exception and show the error.
			
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
			print_r($error);
		}

}

?>
<?php include("header.php"); ?>
<div class="container">
    <div class="page-content leftdetails">
    	<div class="row">
		  <div class="col-md-3 col-lg-2">
		  	<?php include("left_navigation.php"); ?>
		  </div>
           
          <div class="col-md-9 col-lg-10">
		  	<div class="row">
			   
			  <!-- breadcrumb-->
				 <div class="col-md-12 btn-group btn-breadcrumb">
					<span class="btn btn-default"><a href="index.php"><i class="glyphicon glyphicon-home"></i></a></span>
					<span class="btn btn-default active"><a>Add Profile</a></span>
					
					
                    
				</div>
			   <!-- close breadcrumbs -->
			   
				 <div class="col-md-12 panel-info">	
				 <div class="content-box-header panel-heading" style="height:55px !important;">
					<div class="panel-title capital">Add User Information </div>
					<div class="panel-options"> 
					
				  </div>
				  </div>
				<div class="content-box-large box-with-header">
					<div class="row">
                     <div class="col-md-12">
						<div class="col-md-9">
			
                  <?php if(isset($msg)){ echo '<p class="alert alert-success">'.$msg.'</p>'; }?>
              <form role="form" method="post" action="" class="form-horizontal" autocomplete="off" id="add_profile" enctype="multipart/form-data">
			               
                
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="User Name">Name <span class="required">*</span> : </label>
                    <div class="col-sm-9">
                       <input type="text" name="name" id="name" class="form-control input_edit"  value="">
                    </div>
                  </div>
                  
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="E-mail Address">E-mail <span class="required">*</span> : </label>
                    <div class="col-sm-9">	
                      <input class="form-control input_edit" type="text" name="email" id="email" value="">
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <label class="control-label col-sm-3" for="password">Password <span class="required">*</span> : </label>
                    <div class="col-sm-9">
                      <input class="form-control input_edit" type="password" name="password" id="password" value="">  
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="Profile Image">Profile Image : </label>
                    <div class="col-sm-9">
					<input type="file" name="profile_image" class="btn btn-primary" accept="image/*" />
                    </div>
                  </div>
                
               
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="url">URL : </label>
                    <div class="col-sm-9">
                      <input type="text" name="url" id="url" class="form-control input_edit"  value="" >
                    </div>
                  </div>
				  
				   <div class="action">
                         <input type="submit" name="submit" value="ADD" class="btn btn-primary signup pull-right" tabindex="5">                         
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

