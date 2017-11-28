<?php
require('../config.php');
//if logged in redirect to members page
if($_SESSION['admin']!='admin' || empty($_SESSION['adminuser'])) { header('Location: login.php'); }  
$title = "Change Password";
?>

<?php
if(isset($_POST['submit'])){ //die("dd");
	try {
	
		    $id=$_SESSION['id'];
			//insert into database with a prepared statement
			$stmt = $db->prepare("UPDATE admin SET password = :password where id = '$id'");
			//print_r("hello");exit;
			$stmt->execute(array(
				':password' => $_POST['password'],
			));
			
			$msg = "Password Reset successfully";	
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
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
					<span class="btn btn-default active">Change Password</span>
				</div>
			   <!-- close breadcrumbs -->
			   
				 <div class="col-md-12 panel-info">	
				 <div class="content-box-header panel-heading" style="height:55px !important;">
					<div class="panel-title "><?php echo $title; ?></div>
					<div class="panel-options"> 
					
				  </div>
				  </div>
				<div class="content-box-large box-with-header">
					<div class="row">
                     <div class="col-md-12">
						<div class="col-md-9">
                     
               
                 
                  <?php if(isset($msg)){ echo '<p class="alert alert-success">'.$msg.'</p>'; }?>
              <form role="form" method="post" action="" class="form-horizontal" autocomplete="off" id="change_password">
			               
                
                  	
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="Password">Password : </label>
                    <div class="col-sm-9">
                       <input type="password" name="password" id="password" class="form-control"  value="" >
                    </div>
                  </div>                  
                  
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="confirm_password">Confirm Password : </label>
                    <div class="col-sm-9">
                      <input class="form-control" type="password" name="confirm_password" id="confirm_password" value="">
                    </div>
                  </div>
                  
                  <div class="action">
                         <input type="submit" name="submit" value="Change Now" class="btn btn-primary signup" tabindex="5">                         
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
