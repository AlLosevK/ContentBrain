<?php 
$title="Dashboard - ContentBrain";
include('header.php');?>    
   <main class="container campaigns">
        <div class="container-coll">
            <h2 class="campaigns__tittle">projects</h2>
            <div class="projects container-wrap">
                <a href="newProject.php" class="projects__item projects__new">
                   <div class="pseudo pseudo-plus">New Project</div>
                </a>
				<?php
					$uid=$_SESSION['user_id'];
					$sql = $db->prepare("SELECT * FROM projects where uid='$uid'");
					$sql->execute();
					$sqll = $db->prepare("SELECT FOUND_ROWS()");
					$sqll->execute();
					$totalrow = $sqll->fetchColumn();
					$i = 0;
					
					$arr = array();
					if($totalrow > 0) {
						$result = $sql->fetchAll();
						foreach ($result as $row)
						{?>
							<a href="projectDashboard.php?pid=<?php echo $row[id];?>" class="projects__item"><?php echo $row['project_name'];?></a>
						<?php
						}
					}
				?>
                
            </div>
        </div>
    </main>
 
 <?php include('footer.php');?> 