<?php 

$title="Core Topic - ContentBrain";
include('header.php');
if(!isset($_GET['pid']) || $_GET['pid']==0){
	header("location:index.php");
}

if(isset($_POST['submit'])){ //die("dd");
	try {
		$pid=$_GET['pid'];
		$date=date('Y-m-d h:i A');
		if(isset($_GET['cid']))
		{
			$cid=$_GET['cid'];
			//update into database with a prepared statement
				$stmt = $db->prepare("UPDATE `coreTopics` SET `topic_name`=:topic_name WHERE id='$cid'");
				//print_r("hello");exit;
				$stmt->execute(array(
					':topic_name' => $_POST['topic_name'],
				));
				
		}	
		else
		{
			//insert into database with a prepared statement
				$stmt = $db->prepare("INSERT INTO `coreTopics`( `pid`, `topic_name`) VALUES (:pid, :topic_name)");
				//print_r("hello");exit;
				$stmt->execute(array(
					':pid' => $pid,
					':topic_name' => $_POST['topic_name'],
				));
				$cid=$db->lastInsertId();
				
		}	
		
		pageName($cid,'campaigns.php');
		
		header("location:campaigns.php?cid=".$cid);
		
	} catch(PDOException $e) {
		    $error[] = $e->getMessage();
	}
}

$pid=$_GET['pid'];
$project_name=get_projectname($pid);	
		
?>  
 <main class="container newtopics">
        <div class="container-coll">
            <h2 class="newtopics__tittle main__tittle"><?php echo $project_name;?></h2>
            <form method="post" id="core_topic" class="newtopic container-coll" name="core_topic">
                <input type="text" name="topic_name" class="newtopic__name newtopic__item" placeholder="what's your core topic" autofocus required value="<?php echo $topic_name;?>">
                <button type="submit" name="submit" class="newtopic__check newtopic__item">GO</button>
            </form>
        </div>
    </main>
 <?php include('footer.php');?> 