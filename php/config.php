<?php
session_start();

$setLang = array(
                "it" => array("it","L1"),
                "en" => array("en","L2")
                );

define('DIR_SELF',$_SERVER['PHP_SELF']);
define('DIR_ROOT','');
define('DIR_PHP','php/');
define('DIR_MOD','modules/');
define('DIR_IMAGES','images/');



require_once(DIR_PHP . 'connection.php');
require_once(DIR_PHP . 'functions.php');


?>
