<?php 
$title="Approve Subtopic - ContentBrain";
include('header.php');

if(!isset($_GET['cid'])){
	header("location:index.php");
}

/* initialize variable */
$keywords_arr=array();
$traffic_arr=array();
$rel_arr=array();
$comp_arr=array();

/* Get Keywords */	
$stmt = $db->prepare('SELECT * FROM keywords WHERE cid = :cid');
$stmt->execute(array(':cid' => $cid));
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($row as $result)
{
	$key= $result['keywords'];
	$value=explode(",",$key);
	$keywords_arr[]=$value[0];
	$traffic_arr[]=$value[1];
	$rel_arr[]=$value[2];
	$comp_arr[]=$value[3];
}	
$totalkeywords=count($keywords_arr);
if(!empty($keywords_arr)){
	$_SESSION['subtopics']=$keywords_arr;
	$rel_avg = array_sum($rel_arr) / count($rel_arr); 
	$comp_avg = array_sum($comp_arr) / count($comp_arr); 
}

if(isset($_POST['submit'])){ 
 try {
	$contenttype=$_POST['contenttype'];
	$type=implode(',',$contenttype);
	$stmt = $db->prepare("UPDATE `keywords` SET `type`=:type WHERE `cid`='$cid'");
				
	$stmt->execute(array(
		':type' => $type,
	));
	
	pageName($cid,'approveTitle.php');
	header('location:approveTitle.php?cid='.$cid);
	exit;
			
	} catch(PDOException $e) {
		    $error[] = $e->getMessage();
	}
}

if(!empty($keywords_arr)){
$ctype=array();
$sql = $db->prepare('SELECT * FROM keywords WHERE cid = :cid');
$sql->execute(array(':cid' => $cid));
$row = $sql->fetch(PDO::FETCH_ASSOC);
extract($row);
$type= $row['type'];
$ctype=explode(',',$type);
}	
?>  
   <main class="container newtopics3">
        <div class="container-coll">
            <h2 class="newtopics3__tittle main__tittle"><?php echo $project_name;?></h2>
            <span class="newtopics3__descr main__descr">A core topic for <?php echo $topic_name;?></span>
			<?php if(!empty($keywords_arr)){ ?>
			<form method="post" name="keyword_type" id="keywordType">
			<input type="hidden" value="<?php echo $totalkeywords;?>" name="total_keywords" id="total_Keywords">
            <div class="container-wrap subtopics">
                <div class="subtopic container-coll">
                    <h3 class="subtopic__tittle">Subtopics</h3>
					<?php foreach($keywords_arr as $key)
					{
						echo '<span class="subtopic__descr">'.$key.'</span>';
					}
					?>
                 </div>
                <div class="contenttype container-coll">
                    <h2 class="contenttype__tittle">what type of content are you creating? select that apply</h2>
                    <div class="container-wrap">
                        <div class="contenttype-coll container-coll">
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-1" class="contenttype__checkbox" value="Lists" <?php if(!empty($ctype)){if(in_array('Lists',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-1" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Lists</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-2" class="contenttype__checkbox" value="How-To" <?php if(!empty($ctype)){if(in_array('How-To',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-2" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">How-To</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-3" class="contenttype__checkbox" value="Questions & Answers (Q&A)" <?php if(!empty($ctype)){if(in_array('Questions & Answers (Q&A)',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-3" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Questions & Answers (Q&A)</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-4" class="contenttype__checkbox" value="Case Studies" <?php if(!empty($ctype)){if(in_array('Case Studies',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-4" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Case Studies</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-5" class="contenttype__checkbox" value="Testimonials" <?php if(!empty($ctype)){if(in_array('Testimonials',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-5" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Testimonials</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-6" class="contenttype__checkbox" value="Interviews" <?php if(!empty($ctype)){if(in_array('Interviews',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-6" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Interviews</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-7" class="contenttype__checkbox" value="Demos" <?php if(!empty($ctype)){if(in_array('Demos',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-7" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Demos</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-8" class="contenttype__checkbox" value="Product Review" <?php if(!empty($ctype)){if(in_array('Product Review',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-8" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Product Review</label>
							
							<input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="Templates" <?php if(!empty($ctype)){if(in_array('Templates',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Templates</label>
							
							<input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="E-Books" <?php if(!empty($ctype)){if(in_array('E-Books',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">E-Books</label>
							
							<input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="Public Service Announcements (PSAs)" <?php if(!empty($ctype)){if(in_array('Public Service Announcements (PSAs)',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Public Service Announcements (PSAs)</label>
                        </div>
                        <div class="contenttype-coll container-coll">
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-9" class="contenttype__checkbox" value="Comparsions & Versus" <?php if(!empty($ctype)){if(in_array('Comparsions & Versus',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-9" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Comparsions & Versus</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-10" class="contenttype__checkbox" value="Company News" <?php if(!empty($ctype)){if(in_array('Company News',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-10" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Company News</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-11" class="contenttype__checkbox" value="Industry News" <?php if(!empty($ctype)){if(in_array('Industry News',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-11" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Industry News</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-12" class="contenttype__checkbox" value="Roundups" <?php if(!empty($ctype)){if(in_array('Roundups',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-12" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Roundups</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-13" class="contenttype__checkbox" value="Book Reviews" <?php if(!empty($ctype)){if(in_array('Book Reviews',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-13" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Book Reviews</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-14" class="contenttype__checkbox" value="Opinions and Rants" <?php if(!empty($ctype)){if(in_array('Opinions and Rants',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-14" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Opinions and Rants</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-15" class="contenttype__checkbox" <?php if(!empty($ctype)){if(in_array('Personal Stories',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-15" class="contenttype__checkbox-custom contenttype__checkbox-custom-text" value="Personal Stories">Personal Stories</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-16" class="contenttype__checkbox" value="Successes" <?php if(!empty($ctype)){if(in_array('Successes',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-16" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Successes</label>
							
							<input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="Whitepaper" <?php if(!empty($ctype)){if(in_array('Whitepaper',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Whitepaper</label>
							
							<input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="Infographics" <?php if(!empty($ctype)){if(in_array('Infographics',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Infographics</label>
							
							<input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="News Releases and Pitches" <?php if(!empty($ctype)){if(in_array('News Releases and Pitches',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">News Releases and Pitches</label>
                        </div>
                         <div class="contenttype-coll container-coll">
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-17" class="contenttype__checkbox" value="Metaphors" <?php if(!empty($ctype)){if(in_array('Metaphors',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-17" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Metaphors</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-18" class="contenttype__checkbox" value="Predictions" <?php if(!empty($ctype)){if(in_array('Predictions',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-18" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Predictions</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-19" class="contenttype__checkbox" value="Failures and What Not to Do" <?php if(!empty($ctype)){if(in_array('Failures and What Not to Do',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-19" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Failures and What Not to Do</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-20" class="contenttype__checkbox" value="Transparency" <?php if(!empty($ctype)){if(in_array('Transparency',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-20" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Transparency</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-21" class="contenttype__checkbox" value="Research" <?php if(!empty($ctype)){if(in_array('Research',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-21" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Research</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-22" class="contenttype__checkbox" value="Facts and Stats" <?php if(!empty($ctype)){if(in_array('Facts and Stats',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-22" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Facts and Stats</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-23" class="contenttype__checkbox" value="Guides" <?php if(!empty($ctype)){if(in_array('Guides',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-23" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Guides</label>
                            
                            <input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="Worksheets" <?php if(!empty($ctype)){if(in_array('Worksheets',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Worksheets</label>
							
							<input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="Checklists" <?php if(!empty($ctype)){if(in_array('Checklists',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Checklists</label>
							
							<input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="Listicle Summaries" <?php if(!empty($ctype)){if(in_array('Listicle Summaries',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Listicle Summaries</label>
							
							<input type="checkbox" name="contenttype[]" id="contenttype__checkbox-24" class="contenttype__checkbox" value="Diagrams" <?php if(!empty($ctype)){if(in_array('Diagrams',$ctype)){echo "checked";}}?>>
                            <label for="contenttype__checkbox-24" class="contenttype__checkbox-custom contenttype__checkbox-custom-text">Diagrams</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-wrap newtopics3__navigation newtopics3__row subtopics__navigation">
                <div class="newtopics3__navigation subtopics__descr container-coll">
                    <span class="subtopics__descr-estimated">Estimated Traffic: <?php echo min($traffic_arr) ?> - <?php echo max($traffic_arr) ?></span>
                    <span class="subtopics__descr-relevance">Relevance: <?php echo $rel_avg;?></span>
                    <span class="subtopics__descr-competiveness">Competiveness: <?php echo $comp_avg;?></span>
                </div>
                <button type="submit" name="submit" class="newtopics3__navigation-item">
                    <span>next</span>
                    <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="27px" height="12px"><path fill-rule="evenodd"  opacity="0.502" fill="rgb(243, 245, 247)" d="M26.274,5.856 L26.274,6.880 L25.930,6.880 L26.263,7.217 L21.553,11.989 L20.221,10.639 L23.931,6.880 L-0.000,6.880 L-0.000,4.832 L23.834,4.832 L20.506,1.460 L21.936,0.012 L26.988,5.132 L26.274,5.856 Z"/></svg>
                </button>
            </div>
           </form>
			<?php } else {echo STEPERROR;} ?>
		</div>
    </main>
   
 <?php include('footer.php');?> 