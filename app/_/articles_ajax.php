<?php
require('simplehtmldom/simple_html_dom.php');

// Create DOM from URL or file
$query = $_POST['title'];
$url = 'http://www.google.co.in/search?q='.urlencode($query).'';

// creating an array of elements
$item = [];
$articles = [];
$i=0;

// Create DOM from URL or file
$html = file_get_html($url);

//echo file_get_html($url)->plaintext; 
$data=array();
$articles=array();

foreach($html->find('div.g') as $article)
{
	if ($i > 11) {
                break;
        }
	if($i!=0){	
		$data['link']  = $article->find('h3.r a', 0)->href;
		$data['title']  = $article->find('h3.r a', 0)->plaintext;
		$data['content']  = $article->find('div.s span.st', 0)->plaintext;
		$data['url']  = $article->find('div.s div.kv cite', 0)->plaintext;
	   $data['link']  =str_replace("/url","https://www.google.com/url",$data['link']);
	   $message .='<div class="resourc">';
       $message .= '<h3 class="resourc__tittle"> <a target="_blank" href="'.$data['link'].'" class="resourc__link">'.$data['title'].'</a></h3>';
	   $message .='<cite>'.$data['url'].'</cite>';
       $message .= '<p class="resourc__descr">'.$data['content'].'</p></div>';
            
		//$articles[] = $data;
	}	
	$i++;
}

# JSON-encode the response
	//$json_response = json_encode($articles);
	
	// # Return the response
	echo $message;  
?>