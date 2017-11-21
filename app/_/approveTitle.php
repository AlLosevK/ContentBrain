<?php 
$title="Select Title - ContentBrain";
include('header.php');

if(!isset($_GET['cid'])){
	header("location:index.php");
}
	
if(isset($_POST['submit']))
{
	$article=$_POST['approve'];
	$total=count($article);
	$i=0;
		
		if($total!=0){
			$date=date('Y-m-d h:i A');
		    $stmt1 = $db->prepare("SELECT * FROM user_selected_articles where cid='$cid'");
			$stmt1->execute();
			$stmt2 = $db->prepare("SELECT FOUND_ROWS()");
			$stmt2->execute();
			$total_rec = $stmt2->fetchColumn();
			if($total_rec > 0) {
				$sql = $db->prepare("delete FROM user_selected_articles where cid='$cid'");
				$sql->execute();
			}
			
			foreach($article as $topic){
				$stmt = $db->prepare("INSERT INTO `user_selected_articles`( `cid`,`title`,`date`) VALUES (:cid, :title,:date)");
				//print_r("hello");exit;
				$stmt->execute(array(
					':cid' => $cid,
					':title' => $topic,
					':date' => $date,
				));
			}	
			pageName($cid,'finalTitle.php');
		}
		
	
	$min = 1;
	if($total>=$min)
	{	
		header('location:finalTitle.php?cid='.$cid);
		exit;
	}
	else
	{
		if($total<$min){$error="You need to select Minimum ".$min." Title";}
	}
	
}	
/* Get articles from db */
$row1=get_article($cid);


?> 

   <main class="container approvecontent">
   <?php if($error!=""){?>
	<div class="alert alert-danger">
		<strong>Error!</strong> <?php echo $error; $error="";?>
	</div>
  <?php } ?>
  
   <form method="post" name="article_approve" id="article_approve">
        <div class="container-coll">
            <h2 class="approvecontent__tittle main__tittle"><?php echo $project_name;?></h2>
            <span class="approvecontent__descr main__descr">A core topic for <?php echo $topic_name;?></span>
			<?php if(is_array($row1)){ ?>
            <table class="approvetable">
                <thead class="approvetable__head">
                    <tr class="approvetable__head-row">
                        <td>approve</td>
                        <td>title</td>
                        <td></td>
                        <td>type</td>
                        <td>internal link</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody class="approvetable__body">
				<?php 
				$i=0;
				 foreach($row1 as $result){
				 $i++;	 
				?>
					  <tr class="approvetable__body-row">
                        <td>
						<input type="checkbox" name="approve[]" id="contenttype__checkbox-<?php echo $i;?>" class="contenttype__checkbox" value="<?php echo $result['title'];?>,<?php echo $result['type'];?>">
                            <label for="contenttype__checkbox-<?php echo $i;?>" class="contenttype__checkbox-custom"></label>
						</td>
                        <td><?php echo $result['title'];?></td>
                        <td></td>
                        <td><?php echo $result['type'];?></td>
                        <td><?php echo $result['link'];?></td>
                        <td>
                        </td>
                    </tr>
				<?php }
				?>
                </tbody>
            </table>
			<?php } else { echo $row1;}  ?>
        </div>
		<?php if(is_array($row1)){ ?>
        <div class="container-wrap approvecontent__navigation approvecontent__row">
            <a href="approveTitle.php?cid=<?php echo $cid;?>" class="approvecontent__navigation-item">
                <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="27px" height="12px"><path fill-rule="evenodd"  opacity="0.502" fill="rgb(243, 245, 247)" d="M27.000,6.880 L3.069,6.880 L6.779,10.639 L5.447,11.989 L0.737,7.217 L1.070,6.880 L0.726,6.880 L0.726,5.856 L0.012,5.132 L5.064,0.012 L6.493,1.460 L3.166,4.832 L27.000,4.832 L27.000,6.880 Z"/></svg>
                <span>try again</span>
            </a>
            <button type="submit" name="submit" class="approvecontent__navigation-item">
                <span>next</span>
                <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="27px" height="12px"><path fill-rule="evenodd"  opacity="0.502" fill="rgb(243, 245, 247)" d="M26.274,5.856 L26.274,6.880 L25.930,6.880 L26.263,7.217 L21.553,11.989 L20.221,10.639 L23.931,6.880 L-0.000,6.880 L-0.000,4.832 L23.834,4.832 L20.506,1.460 L21.936,0.012 L26.988,5.132 L26.274,5.856 Z"/></svg>
            </button>
        </div>
		</form>
		<?php } ?>
   
    </main>
    
 <?php include('footer.php');?> 