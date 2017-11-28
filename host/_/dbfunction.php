<?php
include('config.php');

function wordtracker_keywords($keyword)
{
	$keyword=urlencode($keyword);
   $url='http://api3.wordtracker.com/search?keywords[]='.$keyword.'&metrics[]=competition&metrics[]=kei&metrics[]=iaat&metrics[]=volume&country=global&adults[]=clean&limit=25&app_id=fb69aff8&app_key=57af0bf98c5c56dc0f2cd38859c3770a';

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  curl_close($ch); 
  $result = json_decode($response, TRUE);
  return $result;
}

function get_projectname($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM projects WHERE id = :id');
	$stmt->execute(array(':id' => $id));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	$project_name=$row['project_name'];
	return $project_name;
}

function get_coretopic($cid)
{
	global $db;
	$stmt = $db->prepare('SELECT * FROM coreTopics WHERE id = :id');
	$stmt->execute(array(':id' => $cid));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	$topic_name=$row['topic_name'];
	$pid=$row['pid'];
	$project_name=get_projectname($pid);
	return array($project_name,$topic_name,$pid);
}


function pageName($cid,$page_name){
	global $db;
	$date=date('Y-m-d h:i A');
	/* check user status by topic*/
		$stmt1 = $db->prepare("SELECT * FROM user_status where cid='$cid'");
		$stmt1->execute();
		$stmt2 = $db->prepare("SELECT FOUND_ROWS()");
		$stmt2->execute();
		$total = $stmt2->fetchColumn();
		if($total > 0) {
			/* update into page name*/
			$sql = $db->prepare("UPDATE `user_status` SET `page_name`=:page_name,`modified_date`=:modified_date WHERE cid='$cid'");
			//print_r("hello");exit;
			$sql->execute(array(
				':page_name' =>$page_name,
				':modified_date' =>$date,
			));
		}
		else
		{	
			/* insert into page name*/
			$sql = $db->prepare("INSERT INTO `user_status`(`cid`, `page_name`, `modified_date`) VALUES (:cid,:page_name,:modified_date)");
			//print_r("hello");exit;
			$sql->execute(array(
				':cid' =>$cid,
				':page_name' =>$page_name,
				':modified_date' =>$date,
			));
		}	
}

function get_article($cid)
{
	global $db;
	$keywords_arr=array();
	$stmt = $db->prepare('SELECT * FROM keywords WHERE cid = :cid');
	$stmt->execute(array(':cid' => $cid));
	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($row as $result)
	{
		$key= $result['keywords'];
		$value=explode(",",$key);
		$keywords_arr[]=$value[0];
		$list_type= $result['type'];
	}	
    if($list_type!=""){
		$lists=explode(",",$list_type);
		
		for($i=0;$i<count($keywords_arr);$i++)
		{
			$list= $lists[$i];
			$keywords= $keywords_arr[$i];
			$query = "SELECT * FROM article WHERE type='".$list."' order by RAND() LIMIT 1";
			$stmt1 = $db->prepare($query);
			$stmt1->execute();
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$title=$row1['title'];
			$content = str_replace("___", $keywords, $title);
			$article[$i]['content']=$content;
			$article[$i]['type']=$list;
		}
		//echo "<pre>";print_r($article);echo "</pre>";
		
		return $article;
	}	
	else
	{
		return STEPERROR;
	}	
	
}
?>