<?php
include('../../config.php');

    if(isset($_POST['type'])){
		if($_POST['type']=="checkStatus")
		{
			try {
				$uid=$_POST['uid'];
				$sql = $db->prepare("SELECT * FROM users where id='$uid'");
				$sql->execute();
				while($row=$sql->fetchObject())
				{
					$status_var=$row->status;
					if($status_var==0)
					{
						$status_state=1;
						$status_state1="actived";
						/* Mail */
						$name= $row->name;
						$email=$row->email;
						$mail_msg ='Your Account is <strong style="font-size:16px;margin:0;color:#fff;line-height:18px"> Activated </strong>';
						mail($email,"SMA Account Activated",$mail_msg);
						/* end mail */
					}
					else
					{
						$status_state=0;
						$status_state1="deactived";
						/* Mail */
						$name= $row->name;
						$email=$row->email;
						$mail_msg ='Your Account is <strong style="font-size:16px;margin:0;color:#fff;line-height:18px"> DeActivated </strong>';
						mail($email,"SMA Account Deactivated",$mail_msg,$name);
						/* end mail */
					}
					
					$stmt = $db->prepare("UPDATE users SET status = :status where id = $uid");
					$stmt->execute(array(
							':status' => $status_state
						));
						
					$data['status'] = '1';
					$data['msg'] = $name."'s account is ".$status_state1." successfully.";
					$json_response = json_encode($data);
					
					
				}
			} catch(PDOException $e) {
					$data['status'] = '0';
					$data['msg'] =$e->getMessage();
					$json_response = json_encode($data);
				}
		}
		else if($_POST['type']=="delete")
		{
			try {
				$id = $_POST['id'];
				$db->exec("DELETE FROM users WHERE id=$id");	
				$data['status'] = '1';				
				$data['msg'] = 'User has been deleted successfully.';
				 $json_response = json_encode($data);
				 
			}
			catch(PDOException $e) {
				$data['status'] = '0';
				$data['msg'] =$e->getMessage();
				$json_response = json_encode($data);
			}			
		}
	}
	else
		{	
			$sql = $db->prepare("SELECT * FROM users ORDER BY id DESC");
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
