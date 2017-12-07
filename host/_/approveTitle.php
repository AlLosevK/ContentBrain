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
				$topic=explode(",",$topic);
				$type= $topic[1];
				$title=$topic[0];
				$stmt = $db->prepare("INSERT INTO `user_selected_articles`( `cid`,`type`,`title`,`date`) VALUES (:cid, :type,:title,:date)");
				//print_r("hello");exit;
				$stmt->execute(array(
					':cid' => $cid,
					':type' => $type,
					':title' => $title,
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
$article=get_article($cid);


?>

<main class="container approvecontent">
    <?php if($error!=""){?>
    <div class="alert alert-danger">
        <strong>Error!</strong>
        <?php echo $error; $error="";?>
    </div>
    <?php } ?>

    <form method="post" name="article_approve" id="article_approve">
        <div class="container-coll">
            <h2 class="approvecontent__tittle main__tittle">
                <?php echo $project_name;?>
            </h2>
            <span class="approvecontent__descr main__descr">A core topic for <?php echo $topic_name;?></span>
            <?php if(is_array($article)){ ?>
            <ul class="set__navigation container-wrap">
                <li class="set__navigation-item"><a href="campaigns.php">Metrics</a></li>
                <li class="set__navigation-item"><a href="approveKeywords.php">Content Types</a></li>
                <li class="set__navigation-item"><a class="active pseudo pseudo-dot" href="#">Titles</a></li>
                <li class="set__navigation-item"><a href="finalTitle.php">Research</a></li>
            </ul>
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
				for($i=0;$i<count($article);$i++){
				?>
                    <tr class="approvetable__body-row">
                        <td>
                            <input type="checkbox" name="approve[]" id="contenttype__checkbox-<?php echo $i;?>" class="contenttype__checkbox" value="<?php echo $article[$i]['content'];?>,<?php echo $article[$i]['type'];?>">
                            <label for="contenttype__checkbox-<?php echo $i;?>" class="contenttype__checkbox-custom"></label>
                        </td>
                        <td colspan="2">
                            <div class="block">
                                <input type="text" class="block__input" value="<?php echo $article[$i]['content'];?>" readonly>
                                <button type="button" class=" block__btn">Edit title</button>
                            </div>
                        </td>
                        <td>
                            <?php echo $article[$i]['type'];?>
                        </td>
                        <td colspan="2">
                            <div class="block">
                                <input type="text" class="block__input" value="mysite.com/blog/innerpage/article3" readonly>
                                <button type="button" class="block__btn">Edit url</button>
                            </div>
                        </td>
                    </tr>
                    <?php }
				?>
                </tbody>
            </table>
            <?php } else { echo $article;}  ?>
        </div>
        <?php if(is_array($article)){ ?>
        <div class="container-wrap approvecontent__navigation approvecontent__row">
            <a href="approveTitle.php?cid=<?php echo $cid;?>" class="approvecontent__navigation-item">
                <span class="newtopics2__navigation-back">try again</span>
            </a>
            <button type="submit" name="submit" class="approvecontent__navigation-item">
                <span class="newtopics2__navigation-next">next</span>
            </button>
        </div>
    </form>
    <?php } ?>

</main>

<?php include('footer.php');?>
