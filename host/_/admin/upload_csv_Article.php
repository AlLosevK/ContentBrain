<?php
require('../config.php');
//if logged in redirect to members page
if($_SESSION['admin']!='admin' || empty($_SESSION['adminuser'])) { header('Location: login.php'); }  
$title = "Import CSV";

?>

<?php
if(isset($_POST['submit'])){ //die("dd");
		try {
			//we check,file must be have csv extention
			//validate whether uploaded file is a csv file
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
			if(!empty($_FILES['upload_articles']['name']) && in_array($_FILES['upload_articles']['type'],$csvMimes)){
			  if(is_uploaded_file($_FILES['upload_articles']['tmp_name'])){
				//open uploaded csv file with read only mode
				$csvFile = fopen($_FILES['upload_articles']['tmp_name'], 'r');
				
			  //parse data from csv file line by line
			  while(($users = fgetcsv($csvFile)) !== FALSE){
				$username= $users[1];
				
					$date=date('Y-m-d h:i A');
					//exit;
					//insert into database with a prepared statement
					$stmt = $db->prepare("INSERT INTO `article`(`type`, `title`,`upload_by`,`created_date`, `modified_date`) VALUES (:type,:title,:upload_by,:created_date,:modified_date)");
					$stmt->execute(array(
					':type' => $users[0],
					':title' => $users[1],
					':upload_by' => 'csv',
					':created_date' => $date,
					':modified_date' => $date,
					));
					$inserted_id = $db->lastInsertId();
				}
			  fclose($csvFile);
			  $msg= "CSV File has been successfully Imported.";
				 }
			}
			else {
				$error= "Error: Please Upload only CSV File";
			}
 
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
					<span class="btn btn-default"><a href="articles.php">Articles</a></span>
					<span class="btn btn-default active"><a href="javaScript:">Import CSV</a></span>
                </div>
			   <!-- close breadcrumbs -->
			   
				 <div class="col-md-12 panel-info">	
				 <div class="content-box-header panel-heading" style="height:55px !important;">
					<div class="panel-title capital">Import CSV </div>
					<div class="panel-options"> 
					
				  </div>
				  </div>
				<div class="content-box-large box-with-header">
					<div class="row">
                     <div class="col-md-12">
						<div class="col-md-9">
			
                 <?php if(isset($msg)){ echo '<p class="alert alert-success">'.$msg.'</p>'; }?>
				  <?php if(isset($error)){ echo '<p class="alert alert-danger">'.$error.'</p>'; }?>
              <form role="form" method="post" action="" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
			               
                 <div class="form-group">
                    <label class="control-label col-sm-3" for="Upload CSV">Upload CSV : </label>
                    <div class="col-sm-9">
					  <input type="file" name="upload_articles" class="btn btn-primary"/>
                    </div>
                  </div>
				  
                  <div class="action">
                         <input type="submit" name="submit" value="Upload" class="btn btn-primary signup pull-right" tabindex="5">                         
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


