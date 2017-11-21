 <?php
		
   $currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $filename= $parts[count($parts) - 1];
	
	if($filename=="projectDashboard.php"){
		$nav_title= "project";
	}
	else if($filename=="accountSettings.php"){ 
		$nav_title= "account Settings"; 
	}
	else{ 
		$nav_title= "campaigns"; 
	}
	
	if(isset($_GET['pid'])){
		$query="?pid=".$_GET['pid'];
	}	
	else if(isset($_GET['cid'])){
		$query="?cid=".$_GET['cid'];
	}
	else{
		$query="";
	}
	 
	if($filename=="index.php"){
		$nav_sublink= "logout.php";
		$nav_subtitle= "Logout";
	}
	else if($filename=="newProject.php"){ 
		$nav_sublink= "index.php"; 
		$nav_subtitle= "Projects"; 
	}
	else if($filename=="coreTopic.php"){ 
		$nav_sublink= "newProject.php"; 
		$nav_subtitle= "New Projects"; 
	}
	else if($filename=="campaigns.php"){
		$query.='&pid='.$pid;
	    $nav_sublink= "coreTopic.php".$query; 
		$nav_subtitle= "Core Topic"; 
	}
	else if($filename=="approveKeywords.php"){ 
	    $nav_sublink= "campaigns.php".$query; 
		$nav_subtitle= "Select Subtopics"; 
	}
	else if($filename=="approveTitle.php"){ 
	    $nav_sublink= "approveKeywords.php".$query; 
		$nav_subtitle= "Select Type of Subtopics"; 
	}
	else if($filename=="finalTitle.php"){ 
	    $nav_sublink= "approveTitle.php".$query; 
		$nav_subtitle= "Approve Titles"; 
	}
	else if($filename=="projectDashboard.php"){ 
		$nav_sublink= "coreTopic.php".$query;; 
		$nav_subtitle= "campaigns"; 
	}
	else if($filename=="accountSettings.php"){ 
		$nav_sublink= "javascript:history.back()"; 
		$nav_subtitle= "Previous Page"; 
	}
	
	
	
?>

    
 <div class="navigation">
                <span class="navigation__title"><?php echo $nav_title; ?></span>
                <a href="<?php echo $nav_sublink; ?>" class="navigation__back">
                    <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="8px">
<path fill-rule="evenodd"  fill="rgb(214, 141, 255)"
 d="M16.000,4.880 L3.059,4.880 L4.778,6.639 L3.446,7.989 L0.737,5.217 L1.070,4.880 L0.726,4.880 L0.726,3.856 L0.012,3.132 L3.064,0.012 L4.493,1.460 L3.151,2.832 L16.000,2.832 L16.000,4.880 Z"/>
</svg>
                 <span><?php echo $nav_subtitle; ?></span>
                </a>
            </div>