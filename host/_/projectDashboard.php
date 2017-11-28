<?php 
$title="Project Dashboard - ContentBrain";
include('header.php');

if(!isset($_GET['pid']) || $_GET['pid']==0){
	header("location:index.php");
}

$stmt = $db->prepare('SELECT * FROM projects WHERE id = :id');
$stmt->execute(array(':id' => $_GET['pid']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
extract($row);
?>    
 <main class="container project">
        <div class="container-coll">
            <h2 class="project__tittle"><?php echo $row['project_name'];?></h2>
            <div class="topics container-wrap">
                <a href="coreTopic.php?pid=<?php echo $_GET['pid'];?>" class="topics__item topics__new">
                   <div class="pseudo pseudo-plus">New Topic</div>
                </a>
				<?php
					$pid=$_GET['pid'];
					$sql = $db->prepare("SELECT * FROM coreTopics where pid='$pid'");
					$sql->execute();
					$sqll = $db->prepare("SELECT FOUND_ROWS()");
					$sqll->execute();
					$totalrow = $sqll->fetchColumn();
					$i = 0;
					
					$arr = array();
					if($totalrow > 0) {
						$result = $sql->fetchAll();
						foreach ($result as $row)
						{
							$cid=$row['id'];
							$stmt = $db->prepare("SELECT * FROM user_status where cid='$cid'");
							$stmt->execute();
							$stmtl = $db->prepare("SELECT FOUND_ROWS()");
							$stmtl->execute();
							$totalval = $stmtl->fetchColumn();
							
							if($totalval > 0) {
								$result_page = $stmt->fetch();
								$page_name=$result_page['page_name']."?cid=".$cid;
							}
							else
							{
								$page_name="campaigns.php?cid=".$cid;
							}	
						?>
							<a href="<?php echo $page_name;?>" class="topics__item">
								<span class="topics__item-tittle"><?php echo $row['topic_name'];?></span>
								<div class="topics__content">
								<?php if($result_page['page_name']=="campaigns.php"){?> 
									<span class="topics__content-item">Not Started</span>
								<?php } else if($result_page['page_name']=="finalTitle.php"){?>
									<span class="topics__content-item">Done</span>
								<?php } else {?>
									<span class="topics__content-item">In Progress</span>
								<?php } ?>
								</div>
							</a>
						<?php
						}
					}
				?>
				<!--
                <a href="#" class="topics__item">
                    <span class="topics__item-tittle">Topic #1</span>
                    <div class="topics__content">
                        <span class="topics__content-item">3 Done</span>
                        <span class="topics__content-item">1 In Progress</span>
                        <span class="topics__content-item">4 Not Started</span>
                    </div>
                </a>
                <a href="#" class="topics__item">
                    <span class="topics__item-tittle">Topic #1</span>
                    <div class="topics__content">
                        <span class="topics__content-item">1 Done</span>
                        <span class="topics__content-item">1 In Progress</span>
                        <span class="topics__content-item">4 Not Started</span>
                    </div>
                </a>-->
            </div>
        </div>
    </main>
 <?php include('footer.php');?> 