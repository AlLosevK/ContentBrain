<?php 
require('../config.php');
//if logged in redirect to members page
if($_SESSION['admin']!='admin' || empty($_SESSION['adminuser'])) { header('Location: login.php'); }  
$title = "View Profile";
$uid=$_GET['uid'];
?>
<?php
		 $stmt = $db->prepare('SELECT * FROM users WHERE id = :uid');
		 $stmt->execute(array(':uid' => $_GET['uid']));
		 $row = $stmt->fetch(PDO::FETCH_ASSOC);
		// echo "<pre>";
		//print_r($row);
 ?>
<?php include("header.php"); ?>
<style>
	.input_edit{ border:none !important;}
</style>
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
					<span class="btn btn-default"><a href="editUser.php?uid=<?php echo $uid;?>">Edit Profile</a></span>
					<span class="btn btn-default active"><a href="viewUser.php?uid=<?php echo $uid;?>">View Profile</a></span>
				</div>
			   <!-- close breadcrumbs -->
			   
                 <div class="col-md-12 panel-info">	
				 <div class="content-box-header panel-heading" style="height:55px !important;">
					<div class="panel-title ">View <?php echo $row['name'];?> Details</div>
					<div class="panel-options"> 
					
				  </div>
				  </div>
				<div class="content-box-large box-with-header">
					<div class="row">
                     <div class="col-md-12">
						<div class="col-md-9">
			
               
                 
                  <?php if(isset($msg)){ echo '<p class="alert alert-success">'.$msg.'</p>'; }?>
              <form role="form" method="post" action="" class="form-horizontal" autocomplete="off">
			               
                
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="User Name">Name : </label>
                    <div class="col-sm-9">
                    <label style="text-align:left;" class="form-control input_edit" for="User Name"><?php echo $row["name"];?></label>
                    </div>
                  </div>
                  
                    <div class="form-group">
                    <label class="control-label col-sm-3" for="E-mail Address">E-mail : </label>
                    <div class="col-sm-9">
                    <label style="text-align:left;" class="form-control input_edit" for="E-mail Address"><?php echo $row["email"];?></label>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="Profile Image">Profile Image : </label>
                    <div class="col-sm-9">
                    <?php if($row["profile_image"] != ""){?>
                      <img width="150px" height="150px" style="padding-bottom:10px;" src="<?php echo $row["profile_image"];?>">
					<?php } ?>
                    </div>
                  </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-3" for="Status">Status : </label>
                    <div class="col-sm-9">
                    <label style="text-align:left;" class="form-control input_edit" for="Status">
					<?php if($row["status"]==1){echo "Active";} else { echo "Inactive";}?></label>
                    </div>
                </div>

                    <input type="hidden" name="mid" value="<?php echo $_GET['uid']; ?>">
                            
  
			                <!--<div class="action">
                         <input type="submit" name="submit" value="Edit" class="btn btn-primary signup" tabindex="5">                         
			                </div> -->
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

