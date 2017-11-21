<?php
ob_start();
session_start();
//database credentials
define('DBHOST','localhost');
define('DBUSER','technoar_sma');
define('DBPASS','tf#_0F$$cRCa');
define('DBNAME','technoar_sma');

//application address
define('DIR','http://technoarray.com/php/sma/');
define('PATH',$_SERVER["DOCUMENT_ROOT"].'/');
define('SITEEMAIL','noreply@domain.com');
define('ADMINEMAIL','codecoretesting@gmail.com');

define('STEPERROR','No Result Found, Please complete Previous Steps.');

?>