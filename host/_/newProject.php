<?php 
$title="New Project - ContentBrain";
include('header.php');

if(isset($_POST['submit'])){ //die("dd");
	try {
		$date=date('Y-m-d h:i A');
		/*$url=parse_url($_POST['project_url']);
		$urlhost=$url['host'];
		$sql = $db->prepare("SELECT * FROM projects where project_url='$urlhost'");
		$sql->execute();
		$sqll = $db->prepare("SELECT FOUND_ROWS()");
		$sqll->execute();
		$totalrow = $sqll->fetchColumn();
		
		if($totalrow > 0) {*/
				//exit;
				//insert into database with a prepared statement
			$stmt = $db->prepare("INSERT INTO `projects`( `uid`, `project_name`, `project_url`, `created_date`, `modified_date`) VALUES (:uid, :project_name, :project_url, :created_date,:modified_date)");
				//print_r("hello");exit;
			$stmt->execute(array(
				':uid' => $_SESSION['user_id'],
				':project_name' => $_POST['project_name'],
				':project_url' => $_POST['project_url'],
				':created_date' => $date,
				':modified_date' => $date,
			));
			
			$pid=$db->lastInsertId();
			header("location:coreTopic.php?pid=".$pid);
		/*}
		else
		{
			 $error[] ="Url already exists";
		}	*/
	} catch(PDOException $e) {
		    $error[] = $e->getMessage();
	}
}		
?>  

 <main class="container newprojects">
        <div class="container-coll">
            <h2 class="newproject__tittle main__tittle">new projects</h2>
			<?php
			//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="alert alert-danger">'.$error.'</p>';
					}
				}
			?>	
            <form method="post" class="newproject container-coll" name="newproject" id="newproject">                
                <input type="text" name="project_name" class="newproject__name newproject__item" placeholder="project name" autofocus required>
                <input type="text" name="project_url" class="newproject__url login__item" placeholder="url" required>
                <button type="submit" name="submit" class="newproject__check newproject__item">GO</button>
            </form>
        </div>
    </main>
 <?php include('footer.php');?> 