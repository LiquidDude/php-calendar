<?php
if ($_SERVER["HTTP_HOST"]=="192.168.1.1"):
  $db_host="localhost";
  $db_name="cmsdgNet_florencedreamit";
  $db_user="root";
  $db_pass="";

else: // online

  	$db_host = "localhost";
	$db_name="golem_ld50";
	$db_user="code1981";
	$db_pass="marzo30po";

endif;

$connessione = mysql_connect ($db_host, $db_user, $db_pass) or die ("MySql dice: " . mysql_error());
$db = mysql_select_db ($db_name, $connessione) or die ("MySql dice: " . mysql_error());
mysql_query("SET NAMES 'utf8'");
error_reporting(0);

?>
