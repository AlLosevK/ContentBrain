<?php
 $title = "Edit Article";
require('header.php');

$id=$_GET['id'];

?>

<?php
if(isset($_POST['submit'])){ //die("dd");
		try {
		
		/* Check Updated field for Mail */
		    $id = $_POST['id'];
			$date=date('Y-m-d h:i A');
			//update into database with a prepared statement
			$stmt = $db->prepare("UPDATE article SET `type`=:type,`title`=:title, `modified_date`=:modified_date where id = $id");
			//print_r("hello");exit;
			$stmt->execute(array(
				':type' => $_POST['type'],
				':title' => $_POST['title'],
				':modified_date'=>$date,
			));
			
			
			$msg = "Article updated successfully";	
			
		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
			print_r($error);
		}

}

?>
<?php
		$stmt = $db->prepare('SELECT * FROM article WHERE id = :id');
		$stmt->execute(array(':id' => $_GET['id']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//extract($row);
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
					<span class="btn btn-default"><a href="articles.php">Articles</a></span>
					<span class="btn btn-default active"><a href="editArticle.php?uid=<?php echo $uid;?>">Edit Article</a></span>
					
                    
				</div>
			   <!-- close breadcrumbs -->
			   
				 <div class="col-md-12 panel-info">	
				 <div class="content-box-header panel-heading" style="height:55px !important;">
					<div class="panel-title capital">Edit Information </div>
					<div class="panel-options"> 
					
				  </div>
				  </div>
				<div class="content-box-large box-with-header">
					<div class="row">
                     <div class="col-md-12">
						<div class="col-md-9">
			
                  <?php if(isset($msg)){ echo '<p class="alert alert-success">'.$msg.'</p>'; }?>
              <form role="form" method="post" action="" class="form-horizontal" autocomplete="off" id="edit_article">
			               
                
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="type">Type <span class="required">*</span> : </label>
                    <div class="col-sm-9">
                       <input type="text" name="type" id="type" class="form-control input_edit"  value="<?php echo $row["type"];?>">
                    </div>
                  </div>
                  
                  	<div class="form-group">
                    <label class="control-label col-sm-3" for="E-mail Address">Title <span class="required">*</span> : </label>
                    <div class="col-sm-9">
                      <textarea class="form-control input_edit" type="text" name="title" id="title"><?php echo $row["title"];?></textarea>
                    </div>
                  </div>
                  
                  
                   <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            
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


