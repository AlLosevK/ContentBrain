<?php
ob_start();
session_start();
//database credentials
define('DBHOST','localhost');
define('DBUSER','contentb_sma');
define('DBPASS','F3$aA75i*1Z7');
define('DBNAME','contentb_sma');

//application address
define('DIR','https://app.content-brain.com/');
define('PATH',$_SERVER["DOCUMENT_ROOT"].'/');
define('SITEEMAIL','noreply@domain.com');
define('ADMINEMAIL','codecoretesting@gmail.com');

define('STEPERROR','No Result Found, Please complete Previous Steps.');

?>