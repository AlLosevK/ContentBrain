<?php 
$title="Approve Title - ContentBrain";
include('header.php');

if(!isset($_GET['cid'])){
	header("location:index.php");
}

if(isset($_POST['submit'])){
	pageName($cid,'finalTitle.php');
}

$title=array();
$stmt1 = $db->prepare("SELECT * FROM user_selected_articles where cid='$cid'");
	$stmt1->execute();
	$stmt2 = $db->prepare("SELECT FOUND_ROWS()");
	$stmt2->execute();
	$total_rec = $stmt2->fetchColumn();
	
?>

 <main class="container approvecontent2">
    <form name="finaltitle" method="post">
        <div class="container-coll">
            <h2 class="approvecontent2__tittle main__tittle"><?php echo $project_name;?></h2>
            <span class="approvecontent2__descr main__descr">A core topic for <?php echo $topic_name;?></span>
			<?php
			if($total_rec == 0) {
				echo STEPERROR;
			}
			else{			
			?>
            <table class="approvetable2">
                <thead class="approvetable2__head">
                    <tr class="approvetable2__head-row">
                        <td>title</td>
                        <td></td>
                        <td>type</td>
                        <td>stage</td>
                        <td></td>
                        <td>research</td>
                    </tr>
                </thead>
                <tbody class="approvetable2__body">
				<?php
				$row = $stmt1->fetchAll(PDO::FETCH_ASSOC);
				foreach($row as $result)
				{
				?>
				<tr class="approvetable2__body-row">
                        <td><?php echo $result['title'];?></td>
                        <td></td>
                        <td><?php echo $result['type'];?></td>
                        <td>
                            <select size="1" name="stage">
                                <option value="s1">Finished</option>
                                <option value="s2">In Progress</option>
                                <option value="s3" selected>Not Started</option>
                            </select>
                        </td>
                        <td></td>
                        <td>
                            <a href="javaScript:" data-title="<?php echo $result['title'];?>" class="approvecontent2__button js-show__button-things approvecontent2__button-item">find sourses</a>
                        </td>
                </tr>
				<?php
				}	
				?>
                </tbody>
            </table>
			<?php } ?>
        </div>
		<?php if($total_rec != 0) {?>
		   <div class="container-coll resources resources-item js-show-block-thing">
            <h2 class="resources__tittle">Here are some articles to inspire you:</h2>
			<div class="loader"><img src="img/loader.gif" alt="loader"/></div>
            <div class="articles">
                
            </div>
            
          </div>
        
        <div class="container-wrap approvecontent2__navigation approvecontent2__row">
      
           <button type="submit" name="submit" class="approvecontent2__navigation-item">
			<span>save</span>
			<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="15px"><path fill-rule="evenodd"  opacity="0.502" fill="rgb(243, 245, 247)" d="M19.994,1.516 L8.372,14.986 L7.792,14.344 L7.559,14.580 L0.506,7.460 L1.935,6.012 L8.093,12.228 L18.633,0.012 L19.994,1.516 Z"/></svg>
            </button>
        </div>	
		<?php } ?>		
		</form>    
	 </main>  
<?php include('footer.php');?>  