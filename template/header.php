<!DOCTYPE html>
<html lang="<? echo $lang; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript">
var lang='<? echo $lang; ?>';
</script>

<link rel="stylesheet" type="text/css" href="<?php echo DIR_ROOT;?>css/reset.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo DIR_ROOT;?>css/grid12.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo DIR_ROOT;?>css/style.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo DIR_ROOT;?>css/font-awesome-4.6.1/css/font-awesome.min.css" media="all" />

<meta name="author" content="" />
<meta name="copyright" content="" />
<meta name="robots" content="index,follow" />

<!-- Favicon -->

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

<title>CMS Calendar</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<?
$canonicalA=basename($_SERVER['PHP_SELF']);
$canonicalZ='';
$canonicalQ=$_SERVER['QUERY_STRING'];
if ($canonicalQ!=''):
	$canonicalZ='?'.$canonicalQ;
endif;
$canonicalNamePage=$canonicalA.$canonicalZ;
?>

<? if ($siteDomain != ''): ?>
		<link rel="canonical" href="<? echo $siteDomain; ?>/<? echo $lang; ?>/<? echo $canonicalNamePage; ?>" />
<? endif; ?>

<meta property="og:site_name" content="" />
<meta property="og:type" content="website" />
<meta property="og:title" content="" />
<meta property="og:description" content="" />
<meta property="og:locale" content="it_IT" />
<meta property="og:url" content="" />
<meta property="article:publisher" content="" />
<meta property="og:image" content="" />

</head>
<body>

<?php

	switch($lang):
			case "it":
					$dateSet = array(
														'weekDay' => array(1=>'Lun','Mar','Mer','Gio','Ven','Sat','Dom'),
														'month' => array(1=>'Gennaio', 'Febbraio', 'Marzo', 'Aprile','Maggio', 'Giugno', 'Luglio', 'Agosto','Settembre', 'Ottobre', 'Novembre','Dicembre')
													);
			break;

			case "en":
					$dateSet = array(
														'weekDay' => array(1=>'Lun','Mar','Mer','Gio','Ven','Sat','Dom'),
														'month' => array(1=>'Gennaio', 'Febbraio', 'Marzo', 'Aprile','Maggio', 'Giugno', 'Luglio', 'Agosto','Settembre', 'Ottobre', 'Novembre','Dicembre')
													);
			break;
	endswitch;

?>

<header>
	<div class="container">
	 <nav class="main_nav center_vert">
		 <!--
		 <a class="btn btn_nav" href="<? echo DIR_SELF; ?>?display=cal">Calendario</a>
		 <a class="btn btn_nav" href="<? echo DIR_SELF; ?>?display=list">Lista</a>
		 <a class="btn btn_nav" href="<? echo DIR_SELF; ?>?display=age">Agenda</a>
	 	-->
	 </nav>
 </div>
</header>
