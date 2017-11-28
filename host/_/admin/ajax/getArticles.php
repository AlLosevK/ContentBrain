<?php
include('../../config.php');

     if(isset($_POST['type']))
	{
		if($_POST['type']=="delete"){
			try {
				$id = $_POST['id'];
				$db->exec("DELETE FROM article WHERE id=$id");				
				 $data['status'] = '1';
				 $data['msg'] = 'Article has been deleted successfully.';
				$json_response = json_encode($data);
			} catch(PDOException $e) {
			   $data['status'] = '0';
				$data['msg'] =$e->getMessage();
				$json_response = json_encode($data);
			}
		}	
	}	
	else{	
			$sql = $db->prepare("SELECT * FROM article ORDER BY id DESC");
					$sql->execute();
					$sqll = $db->prepare("SELECT FOUND_ROWS()");
					$sqll->execute();
					$totalrow = $sqll->fetchColumn();
					
						$i = 0;
					

			$arr = array();
			if($totalrow > 0) {
				$result = $sql->fetchAll();
				foreach ($result as $row)
				{
					$arr[] = $row;	
				}
			}
			# JSON-encode the response
			$json_response = json_encode($arr);
	}	
	// # Return the response
	echo $json_response;
?>
