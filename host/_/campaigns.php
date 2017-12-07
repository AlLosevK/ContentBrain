<?php 
$title="Campaigns - ContentBrain";
include('header.php');


if(!isset($_GET['cid'])){
	header("location:index.php");
}


if(isset($_POST['submit'])){ 
	try {
		$subtopic = $_POST['keywords'];
		$total=count($subtopic);
		$i=0;
		
		if($total!=0){
			$date=date('Y-m-d h:i A');
		    $stmt1 = $db->prepare("SELECT * FROM keywords where cid='$cid'");
			$stmt1->execute();
			$stmt2 = $db->prepare("SELECT FOUND_ROWS()");
			$stmt2->execute();
			$total_rec = $stmt2->fetchColumn();
			if($total_rec > 0) {
				$sql = $db->prepare("delete FROM keywords where cid='$cid'");
				$sql->execute();
			}
			foreach($subtopic as $topic){
				$stmt = $db->prepare("INSERT INTO `keywords`( `pid`,`cid`,`keywords`) VALUES (:pid,:cid, :keywords)");
				//print_r("hello");exit;
				$stmt->execute(array(
					':pid' => $pid,
					':cid' => $cid,
					':keywords' => $topic,
				));
			}
			pageName($cid,'approveKeywords.php');
		}
		
		
		$min = 1;
		$max = 12;
		if($total>=$min && $total <=$max)
		{	
			header('location:approveKeywords.php?cid='.$_GET['cid']);
			exit;
		}
		else
		{
			if($total<$min){$error="You need to select Minimum ".$min." Subtopics";}
			else if($total>$max){$error="You can select Maximum ".$max." Subtopics";}
		}
	} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

}


?>
<main class="container newtopics2">
    <?php
 
	$keyword_result=wordtracker_keywords($topic_name);
	$i=0;
	//echo "<pre>";print_r($keyword_result);echo "</pre>";
	if (array_key_exists('error', $keyword_result)) {
		echo "<h2 style='text-align:center;'>".$keyword_result['error']."</h2>";
	}
	else{
	?>
        <div class="error">
            <?php echo $error; $error="";?>
        </div>
        <form method="post" name="subtopic_form" id="subtopic_form">
            <div class="container-coll">
                <h2 class="newtopics2__tittle main__tittle">
                    <?php echo $project_name;?>
                </h2>
                <span class="newtopics2__descr main__descr">A core topic for <?php echo $topic_name;?></span>
                <ul class="set__navigation container-wrap">
                    <li class="set__navigation-item"><a class="active pseudo pseudo-dot" href="#">Metrics</a></li>
                    <li class="set__navigation-item"><a href="approveKeywords.php">Content Types</a></li>
                    <li class="set__navigation-item"><a href="approveTitle.php">Titles</a></li>
                    <li class="set__navigation-item"><a href="finalTitle.php">Research</a></li>
                </ul>
                <table class="topictable">
                    <thead class="topictable__head">
                        <tr class="topictable__head-row">
                            <td>
                                subtopic
                            </td>
                            <td>
                                traffic
                                <button class="pseudo-info topictable__head-info"></button>
                                <p class="topictable__head-descr traffic">The number of times this keyword has been searched for.</p>
                            </td>
                            <td>
                                IAAT
                                <button class="pseudo-info topictable__head-info"></button>
                                <p class="topictable__head-descr iaat">The number of pages where the keyword is in both the title and the content of a backlink.</p>
                            </td>
                            <td>
                                competition
                                <button class="pseudo-info topictable__head-info"></button>
                                <p class="topictable__head-descr competition">The higher this number, the more competition for this keyword.</p>
                            </td>
                            <td>
                                KEI
                                <button class="pseudo-info topictable__head-info"></button>
                                <p class="topictable__head-descr kei">Keyword Effectiveness Index goes up when the popularity icreases, but down when it becomes more competitive.</p>
                            </td>
                            <td>
                                select
                            </td>
                        </tr>
                    </thead>
                    <tbody class="topictable__body">
                        <?php
				
					foreach($keyword_result['results'] as $result){
						$i++;
					?>
                            <tr class="topictable__body-row">
                                <td>
                                    <?php echo $result['keyword'];?>
                                </td>
                                <td>
                                    <?php echo $result['volume'];?>
                                </td>
                                <td>
                                    <?php echo $result['iaat'];?>
                                </td>
                                <td>
                                    <?php echo $result['competition'];?>
                                </td>
                                <td>
                                    <?php echo $result['kei'];?>
                                </td>
                                <td>
                                    <?php 
						 if(isset($_SESSION['subtopics'])){
							 if(in_array($result['keyword'],$_SESSION['subtopics'])){
								 $checked= "checked";}
							  else{$checked="";}
							}?>
                                    <input type="checkbox" name="keywords[]" id="topictable__checkbox<?php echo $i;?>" class="topictable__checkbox" value="<?php echo $result['keyword'].','.$result['volume'].','.$result['iaat'].','.$result['competition'];?>" <?php echo $checked;?>>
                                    <label for="topictable__checkbox<?php echo $i;?>" class="topictable__checkbox-custom"></label>
                                </td>
                            </tr>
                            <?php } ?>

                    </tbody>
                </table>

            </div>
            <div class="container-wrap newtopics2__navigation newtopics2__row">
                <a href="coreTopic.php?pid=<?php echo $pid;?>&cid=<?php echo $cid;?>" class="newtopics2__navigation-item">
                <span class="newtopics2__navigation-back">try new topic</span>
            </a>
                <button type="submit" class="newtopics2__navigation-item" name="submit">
                <span class="newtopics2__navigation-next">next</span>
            </button>
            </div>
        </form>
        <?php } ?>
</main>

<?php include('footer.php');?>
