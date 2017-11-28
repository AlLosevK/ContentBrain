<?php
 $title = "Add Article";
require('header.php');


?>

<?php
if(isset($_POST['submit'])){ //die("dd");
		try {
		
			$date=date('Y-m-d h:i A');
			//insert into database with a prepared statement
			$stmt = $db->prepare("INSERT INTO `article`(`type`, `title`,`created_date`, `modified_date`) VALUES (:type,:title,:created_date,:modified_date)");
			//print_r("hello");exit;
			$stmt->execute(array(
				':type' => $_POST['type'],
				':title' => $_POST['title'],
				':created_date' =>$date,
				':modified_date' =>$date,
			));
			
			
			$msg = "Article updated successfully";	
			
		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
			print_r($error);
		}

}

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
					<span class="btn btn-default"><a href="articles.php">Articles</a></span>
					<span class="btn btn-default active"><a>Add Article</a></span>
					
                    
				</div>
			   <!-- close breadcrumbs -->
			   
				 <div class="col-md-12 panel-info">	
				 <div class="content-box-header panel-heading" style="height:55px !important;">
					<div class="panel-title capital">Add Information </div>
					<div class="panel-options"> 
					
				  </div>
				  </div>
				<div class="content-box-large box-with-header">
					<div class="row">
                     <div class="col-md-12">
						<div class="col-md-9">
			
                  <?php if(isset($msg)){ echo '<p class="alert alert-success">'.$msg.'</p>'; }?>
              <form role="form" method="post" action="" class="form-horizontal" autocomplete="off" id="add_article">
			               
                
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="type">Type <span class="required">*</span> : </label>
                    <div class="col-sm-9">
                       <input type="text" name="type" id="type" class="form-control input_Add">
                    </div>
                  </div>
                  
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="E-mail Address">Title <span class="required">*</span> : </label>
                    <div class="col-sm-9">
                      <textarea class="form-control input_Add" type="text" name="title" id="title"></textarea>
                    </div>
                  </div>
                  
                  <div class="action">
                         <input type="submit" name="submit" value="Add Now" class="btn btn-primary signup pull-right" tabindex="5">                         
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


