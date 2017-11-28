<?php
include('config.php');

// Generate Order Id
function generate_orderid(){
	$db = new PDO("mysql:host=".DBHOST.";port='';dbname=".DBNAME, DBUSER, DBPASS);
	$order_ref_found = 0; 
	while ($order_ref_found == 0){
		
		 $rand = rand(0, 9999);
		 $today  = substr(str_shuffle(time()),0,6);
		 $unique_id = $today.$rand;
		 
		$stmt= $db->prepare('select COUNT(*) as num_rows from table_orders where order_id=:order_id');
		$stmt->execute(array(':order_id' => $unique_id));
		$num_rows = $stmt->fetchColumn();
		if($num_rows == 0) {
		  $order_id=$unique_id;		
		  $order_ref_found = 1; 
         break;		  
		}  
	}

	return $order_id;
 }

 

/* common functions */

function sendNotifications($uid,$message){
	$db = new PDO("mysql:host=".DBHOST.";port='';dbname=".DBNAME, DBUSER, DBPASS);
  $stmt=$db->prepare("SELECT deviceType,deviceToken FROM table_users WHERE uid=:uid");
  $stmt->execute(array(':uid' => $uid));
  $response = $stmt->fetchAll(); 
  if(count($response)>0){
		if($response[0]['deviceType'] == "1"){
			if($response[0]['deviceToken'] != ""){
				pushNotificationCms($response[0]['deviceToken'],$message);
			 }
		}else{
			if($response[0]['deviceToken']!=""){ 
			   //andriodpushCms($response[0]['deviceToken'],$message,$badgeCount,$totalMessageNotification,$totalRequestPending,$totalFeedsNotification);
			}
			
		}
		
	  }
 }


function pushNotificationCms($deviceToken,$message){


$deviceToken  = $deviceToken;

// Put your private key's passphrase here:
$passphrase = '12345';

// Put your alert message here:
$message = $message;

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'littleThingsPush.pem');
//stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

//echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default',
	'badgecount'=>'1',
	'content-available'=>'1'
	);

// Encode the payload as JSON
$payload = json_encode($body);
// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
		$deliveredMessage= 'Message not delivered' . PHP_EOL;
	else
	    $deliveredMessage= 'Message successfully delivered' . PHP_EOL;

	//echo $deliveredMessage;
	//die;
// Close the connection to the server
fclose($fp);

}

/* Generate PDF */
function generate_pdf($name,$order_id,$title,$description=null,$amount,$status,$date,$from=null)
{
	include_once('mpdf53/vendor/autoload.php'); // PDF Generater

	
    $html='<!DOCTYPE html>
<html lang="en">
<head>
  <title>Example</title>
</head>
	<body style="margin:0; padding:0; color:#fff;">
		<div style="width:768px;margin:auto;font-size:16px;letter-spacing:1px; font-family:arial; font-weight:bold;">
			<div style="width:100%; float:left; padding:20px; background:#2b2d47;">
				<div style="float:left;min-height:175px; width:100%;">
					<div style="float:left;padding:10px;width:150px;">
						<img src="'.DIR.'images/mylogo.png" alt="The Little Things" />
					</div>
					<div style="float:right;margin-top:20px; width:250px;">
						<div style="text-align:right;font-weight:normal;">520 Broadway<br>Santa Monica, California<br>90405<br>United States</div>
					</div>
					<div style="float:right;margin:50px 0; width:250px;">
						<div style="text-align:right;font-size:18px;color:#d7b340;">The Little Things company<br><span style="font-weight:normal;color:#fff; font-size:16px;">310-570-3261</span></div>
					</div>
				</div>
				<div style="float:left;min-height:245px; width:100%;margin:35px 0px;">
					<div style="float:left;">
						<div style="margin:0; width:220px; float:left;font-weight:normal;"><span style="line-height:36px; color:#d7b340; font-size:18px; font-weight:bold;">Billed To</span><br>'.$name.'</div>
						<div style="margin:0; width:157px; float:left;font-weight:normal;"><span style="line-height:36px; font-weight:bold; font-size:18px; color:#d7b340;">Date of Issue</span><br>'.$date.'<br><br><span style="line-height:36px;font-weight:bold; font-size:18px; color:#d7b340;">Due Date</span><br>'.$date.'</div>
						<div style="margin:0; width:196px; float:left;font-weight:normal;"><span style="line-height:36px; font-weight:bold; font-size:18px; color:#d7b340;">Invoice Number</span><br>'.$order_id.'</div>
						<div style="margin:0; width:145px; float:left;"><span style="line-height:36px; color:#d7b340;">Amount Due </span><br>'.$amount.'</div>
						
					</div>
				</div>
				<div style="background:#e0bc65; width:100%; height:4px; float:left;">
				</div>
				<div style="padding:10px 0; width:100%;float:left;">
					<div style="width:100%; float:left;">
						<div style="margin:0; width:415px; float:left; font-weight:normal; text-align:left;"><span style="line-height:48px;font-weight:bold; font-size:18px; color:#d7b340;">Description</span><br>'.$title.'<br>'.$description.'<br></div>
						<div style="margin:0; width:120px; float:left; font-weight:normal; text-align:right;"><span style="line-height:48px; font-weight:bold; font-size:18px; color:#d7b340;">Status</span><br>'.$status.'</div>
						<div style="margin:0; width:50px; float:left; text-align:right;"><span style="line-height:48px; color:#d7b340;"></span><br></div>
						<div style="margin:0; width:110px; float:left; font-weight:normal; text-align:right;"><span style="line-height:48px; font-weight:bold; font-size:18px; color:#d7b340;">Line Total</span><br>'.$amount.'</div>
					</div>
				</div>
				
			
				<div style="width:100%;background:#e0bc65;height:2px; float:left; margin:30px 0;"></div>
				
				
				<div style="width:100%;margin-bottom:30px; float:left;">
					<div style="width:160px; float:right;margin:10px 0 0 0; font-weight:normal; text-align:right;">'.$amount.'</div>
					<div style="width:160px; float:right;margin:10px 0 0 0; color:#d7b340; font-size:18px; text-align:right;">Total </div>
				</div>
			</div>
		</div>
	</body>
</html>';

	// Pdf Functions
			$mpdf = new mPDF('utf-8', 'A4-L'); // New PDF object with encoding & page size
		    $mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
			$mpdf->setAutoBottomMargin = 'stretch'; 
			$mpdf->WriteHTML($html);
			if($from=="web_service")
			{
				$filename = "pdf/".time()."_report.pdf";
			}	
			else
			{
				$filename = "web_service/pdf/".time()."_report.pdf";
			}
			$mpdf->Output($filename);
			/* PDF End */
		 return $filename;
			
}

 /* Generate PDF */
function generate_pdf_both($name,$order_id,$title,$description=null,$amount,$status,$date,$from=null,$image)
{
	include_once('mpdf53/vendor/autoload.php'); // PDF Generater

    $html='<!DOCTYPE html>
<html lang="en">
<head>
  <title>Example</title>
</head>
	<body style="margin:0; padding:0; color:#fff;">
		<div style="width:768px;margin:auto;font-size:16px;letter-spacing:1px; font-family:arial; font-weight:bold;">
			<div style="width:100%; float:left; padding:20px; background:#2b2d47;">
				<div style="float:left;min-height:175px; width:100%;">
					<div style="float:left;padding:10px;width:150px;">
						<img src="'.DIR.'images/mylogo.png" alt="The Little Things" />
					</div>
					<div style="float:right;margin-top:20px; width:250px;">
						<div style="text-align:right;font-weight:normal;">520 Broadway<br>Santa Monica, California<br>90405<br>United States</div>
					</div>
					<div style="float:right;margin:50px 0; width:250px;">
						<div style="text-align:right;font-size:18px;color:#d7b340;">The Little Things Company<br><span style="font-weight:normal;color:#fff; font-size:16px;">310-570-3261</span></div>
					</div>
				</div>
				<div style="float:left;min-height:245px; width:100%;margin:35px 0px;">
					<div style="float:left;">
						<div style="margin:0; width:239px; float:left;font-weight:normal;"><span style="line-height:36px; color:#d7b340; font-size:18px; font-weight:bold;">Billed To</span><br>'.$name.'</div>
						<div style="margin:0; width:260px; float:left;font-weight:normal;"><span style="line-height:36px; font-weight:bold; font-size:18px; color:#d7b340;">Date</span><br>'.$date.'</div>
						<div style="margin:0; width:220px; float:left;font-weight:normal;"><span style="line-height:36px; font-weight:bold; font-size:18px; color:#d7b340;">Invoice Number</span><br>'.$order_id.'</div>

						
					</div>
				</div>';
				if(sizeof($title)==2){
				$html.='
				<div style="background:#e0bc65; width:100%; height:4px; float:left;"></div>
				<div style="padding:10px 0; width:100%;float:left;">
					<div style="width:100%; float:left;">
						<div style="margin:0; width:415px; float:left; font-weight:normal; text-align:left;"><span style="line-height:48px;font-weight:bold; font-size:18px; color:#d7b340;">Credit Description</span><br>';
						$html.= $title[0].'<br>'.$description[0];
						$html.='<br></div><div style="margin:0; width:120px; float:left; font-weight:normal; text-align:right;"><span style="line-height:48px; font-weight:bold; font-size:18px; color:#d7b340;">Status</span><br>'.$status.'</div>
						<div style="margin:0; width:50px; float:left; text-align:right;"><span style="line-height:48px; color:#d7b340;"></span><br></div>
						<div style="margin:0; width:110px; float:left; font-weight:normal; text-align:right;"><span style="line-height:48px; font-weight:bold; font-size:18px; color:#d7b340;">Amount</span><br>';
						$html.= $amount[0];
						$html.='</div>
					</div>
				</div>
				
				<div style="background:#e0bc65; width:100%; height:4px; float:left;"></div>
				<div style="padding:10px 0; width:100%;float:left;">
					<div style="width:100%; float:left;">
						<div style="margin:0; width:415px; float:left; font-weight:normal; text-align:left;"><span style="line-height:48px;font-weight:bold; font-size:18px; color:#d7b340;">Invoice Description</span><br>';
						$html.= $title[1].'<br>'.$description[1];
						$html.='<br></div><div style="margin:0; width:120px; float:left; font-weight:normal; text-align:right;"><span style="line-height:48px; font-weight:bold; font-size:18px; color:#d7b340;">Status</span><br>'.$status.'</div>
						<div style="margin:0; width:50px; float:left; text-align:right;"><span style="line-height:48px; color:#d7b340;"></span><br></div>
						<div style="margin:0; width:110px; float:left; font-weight:normal; text-align:right;"><span style="line-height:48px; font-weight:bold; font-size:18px; color:#d7b340;">Amount</span><br>';
						$html.= $amount[1];
						$html.='</div>
					</div>
				</div>
				
			
				<div style="width:100%;background:#e0bc65;height:2px; float:left; margin:30px 0;"></div>
				
				
				<div style="width:100%;margin-bottom:30px; float:left;">';
				 } else {
				$html.='<div style="background:#e0bc65; width:100%; height:4px; float:left;"></div>
				<div style="padding:10px 0; width:100%;float:left;">
					<div style="width:100%; float:left;">
						<div style="margin:0; width:415px; float:left; font-weight:normal; text-align:left;"><span style="line-height:48px;font-weight:bold; font-size:18px; color:#d7b340;">Credit Description</span><br>';
						$html.= $title[0].'<br>'.$description[0];
						$html.='<br></div><div style="margin:0; width:120px; float:left; font-weight:normal; text-align:right;"><span style="line-height:48px; font-weight:bold; font-size:18px; color:#d7b340;">Status</span><br>'.$status.'</div>
						<div style="margin:0; width:50px; float:left; text-align:right;"><span style="line-height:48px; color:#d7b340;"></span><br></div>
						<div style="margin:0; width:110px; float:left; font-weight:normal; text-align:right;"><span style="line-height:48px; font-weight:bold; font-size:18px; color:#d7b340;">Amount</span><br>';
						$html.= $amount[0];
						$html.='</div>
					</div>
				</div>
				
			
				<div style="width:100%;background:#e0bc65;height:2px; float:left; margin:30px 0;"></div>
				
				
				<div style="width:100%;margin-bottom:30px; float:left;">';
				 } 
					$html.='<div style="width:160px; float:right;margin:10px 0 0 0; font-weight:normal; text-align:right;">';
					if(sizeof($amount)==2){$html.= $amount[1];} else {$html.= $amount[0]; }
					$html.='</div>
					<div style="width:160px; float:right;margin:10px 0 0 0; color:#d7b340; font-size:18px; text-align:right;">Total </div>
				</div>
			</div>';
			
		$html.='</div>
	</body>
</html>';

	// Pdf Functions
			$mpdf = new mPDF('utf-8', 'A4-L'); // New PDF object with encoding & page size
		    $mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
			$mpdf->setAutoBottomMargin = 'stretch';
			$mpdf->WriteHTML($html);
				$mpdf->SetImportUse();
				if($image!=''){
				$pagecount = $mpdf->SetSourceFile($image);
				for ($i=1; $i<=($pagecount); $i++) {
					$mpdf->AddPage();
					$import_page = $mpdf->ImportPage($i);
					$mpdf->UseTemplate($import_page);
					
					
				}
				}
			if($from=="web_service")
			{
				$filename = "pdf/".time()."_report.pdf";
			}	
			else
			{
				$filename = "web_service/pdf/".time()."_report.pdf";
			}
			$mpdf->Output($filename);
			/* PDF End */
		 return $filename;
			
}

 



?>
