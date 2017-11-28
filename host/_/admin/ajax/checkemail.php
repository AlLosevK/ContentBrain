<?php
	header('Content-type: application/json');
	include('../../config.php');
	
	if(isset($_POST['email']))
	{
		$stmt= $db->prepare('select COUNT(*) as num_rows from users where email=:email');
		$stmt->execute(array(':email' =>  $_POST['email']));
		$num_rows = $stmt->fetchColumn();
		if($num_rows != 0) {
			echo json_encode(array('code' => '0', 'msg'=> 'Client with this email id is already exists.'));
		}	
		else
		{
			echo json_encode(array('code' => '1', 'msg' => 'Success'));
		}
	}
?>
