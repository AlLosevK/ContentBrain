<?php
 include("constant.php");
try {

	//create PDO connection 
	$db = new PDO("mysql:host=".DBHOST.";port='';dbname=".DBNAME, DBUSER, DBPASS);
	$db->exec("SET NAMES 'utf8';");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

?>
