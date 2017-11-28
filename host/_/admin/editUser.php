<?php
 $title = "Edit User";
require('header.php');

$uid=$_GET['uid'];

?>

<?php
if(isset($_POST['submit'])){ //die("dd");
		try {
			
		$stmt = $db->prepare('SELECT * FROM users WHERE id = :uid');
		$stmt->execute(array(':uid' => $_GET['uid']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
					
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
					/*delete image from folder*/
					
					if($row['profile_image']){
						$url=$row['profile_image'];
						$path= parse_url($url, PHP_URL_PATH);
						$path = explode( '/', $path );
						$filename=end($path);
						$imagepath=$upload_dir.$filename;
						unlink($imagepath);
					}
					/* end */
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
		else
		{
				$urlWithProImage= $row['profile_image'];
		
		}
		
		/* Check Updated field for Mail */
		    $uid = $_POST['uid'];
			$date=date('Y-m-d h:i A');
			//update into database with a prepared statement
			$stmt = $db->prepare("UPDATE users SET profile_image = :profile_image, url = :url, `modified_date`=:modified_date, name = :name where id = $uid");
			//print_r("hello");exit;
			$stmt->execute(array(
				':profile_image' =>$urlWithProImage,
				':url' => $_POST['url'],
				':name' => $_POST['name'],
				':modified_date' => $date,
			));
			
			
			$msg = "User's profile updated successfully";	
			
		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
			print_r($error);
		}

}

?>
<?php
		$stmt = $db->prepare('SELECT * FROM users WHERE id = :uid');
		$stmt->execute(array(':uid' => $_GET['uid']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		//echo "<pre>";
	   //print_r($row);
?>
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
					<span class="btn btn-default active"><a href="editUser.php?uid=<?php echo $uid;?>">Edit Profile</a></span>
					<span class="btn btn-default"><a href="viewUser.php?uid=<?php echo $uid;?>">View Profile</a></span>
					
                    
				</div>
			   <!-- close breadcrumbs -->
			   
				 <div class="col-md-12 panel-info">	
				 <div class="content-box-header panel-heading" style="height:55px !important;">
					<div class="panel-title capital">Edit <?php $name = explode(' ',trim($row['name'])); echo $name[0]; ?>'s Information </div>
					<div class="panel-options"> 
					
				  </div>
				  </div>
				<div class="content-box-large box-with-header">
					<div class="row">
                     <div class="col-md-12">
						<div class="col-md-9">
			
                  <?php if(isset($msg)){ echo '<p class="alert alert-success">'.$msg.'</p>'; }?>
              <form role="form" method="post" action="" class="form-horizontal" autocomplete="off" id="edit_profile" enctype="multipart/form-data">
			               
                
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="User Name">Name <span class="required">*</span> : </label>
                    <div class="col-sm-9">
                       <input type="text" name="name" id="name" class="form-control input_edit"  value="<?php echo $row["name"];?>">
                    </div>
                  </div>
                  
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="E-mail Address">E-mail <span class="required">*</span> : </label>
                    <div class="col-sm-9">
                      <input class="form-control input_edit" type="text" name="email" id="email" value="<?php echo $row["email"];?>" disabled>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="Profile Image">Profile Image : </label>
                    <div class="col-sm-9">
					<?php if($row["profile_image"] != ""){?>
                      <img width="150px" height="150px" style="padding-bottom:10px;" src="<?php echo $row["profile_image"];?>">
					<?php } ?>
                      <input type="file" name="profile_image" class="btn btn-primary" accept="image/*" />
                    </div>
                  </div>
                
               
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="url">URL : </label>
                    <div class="col-sm-9">
                      <input type="text" name="url" id="url" class="form-control input_edit"  value="<?php echo $row["url"];?>" >
                    </div>
                  </div>
				  
				  
                   <input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>">
                            
  
			                <div class="action">
                         <input type="submit" name="submit" value="Update Now" class="btn btn-primary signup pull-right" tabindex="5">                         
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


