<?php 
$title="Account Settings - ContentBrain";
include('header.php');
$uid=$_SESSION['user_id'];

if(isset($_POST['submit'])){
	
	$stmt = $db->prepare('SELECT * FROM users WHERE id = :uid');
		$stmt->execute(array(':uid' => $uid));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
					
		$profile_image = $_FILES['profile_image']['name'];
		$profile_image_tmp_dir = $_FILES['profile_image']['tmp_name'];
		$profile_image_size = $_FILES['profile_image']['size'];
		//header("Location: userinfo.php");
		if($profile_image)
		{
			$upload_dir = 'images/'; // upload directory	
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
					$urlWithProImage=DIR.$upload_dir.$pro_image;
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
	
	$date=date('Y-m-d h:i A');
	if($_POST['password']!= ""){
		$stmt = $db->prepare("UPDATE `users` SET `url`=:url,`name`=:name,`password`=:password,`profile_image`=:profile_image,`modified_date`=:modified_date WHERE `id`='$uid'");
					
		$stmt->execute(array(
			':url' => $_POST['url'],
			':name' => $_POST['name'],
			':password' => $_POST['password'],
			':profile_image' => $urlWithProImage,
			':modified_date' => $date,
		));
	}
	else
	{
		$stmt = $db->prepare("UPDATE `users` SET `url`=:url,`name`=:name,`profile_image`=:profile_image,`modified_date`=:modified_date WHERE `id`='$uid'");
					
		$stmt->execute(array(
			':url' => $_POST['url'],
			':name' => $_POST['name'],
			':profile_image' => $urlWithProImage,
			':modified_date' => $date,
		));
	}
    $success="User Information updated successfully";	
}

$stmt1 = $db->prepare("SELECT * FROM users where id='$uid'");
$stmt1->execute();
$row = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row);
?>  
  <main class="container accinfo">
  <?php if($success!=""){?>
	<div class="alert alert-success">
		<strong>Success!</strong> <?php echo $success; $success="";?>
	</div>
  <?php } ?>
   <form name="accounts" id="accounts" method="post" class="descr" enctype="multipart/form-data">
        <div class="container-wrap account">
            <div class="container-coll avatar">
                <div class="avatar__img">
				<?php if($row["profile_image"] != ""){?>
                      <img src="<?php echo $row["profile_image"];?>">
				<?php }else{ ?>
                    <img src="img/avatar.png" alt="Avatar">
				<?php } ?>
                </div>
                <div class="avatar__add">
                    <input type="file" name="profile_image" class="avatar__add-fake" id="avatar__add-fake" />
                    <label for="avatar__add-fake" class="avatar__add-file"><span>change image</span></label>
                </div>
            </div>
            <div class="container-coll info">
               
                    <input type="text" name="name" placeholder="john smith" class="descr__name descr__item" value="<?php echo $row['name'];?>">
                    <input type="email" name="email" disabled placeholder="client@mail.com" class="descr__email descr__item" value="<?php echo $row['email'];?>">
                    <input type="password" name="password" placeholder="password" class="descr__pass descr__item">
                    <input type="text" name="url" placeholder="add url" class="descr__url descr__item" value="<?php echo $row['url'];?>">
               
            </div>
        </div>
		<div class="container-wrap approvecontent2__navigation approvecontent2__row">
            <button type="submit" name="submit" class="approvecontent2__navigation-item">
			<span>save</span>
			</button>
        </div>	
	  </form>	
    </main>
   
<?php include('footer.php');?> 