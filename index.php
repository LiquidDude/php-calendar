<?php
		require_once('php/config.php');
		list($lang,$linguaCms) = $setLang['it'];
?>

<!-- TEMPLATE HEADER -->
<?php include_once(DIR_ROOT . 'template/header.php'); ?>
<!--------------------->

<script type="text/javascript">
	//Dichiaro le variabili per il selettore di data ad inizio pagina per evitare errori
	var startYear = '';
	var startMonth = '';
	var startDay = '';

	var endYear = '';
	var endMonth = '';
	var endDay = '';

</script>

<!-- CONTENT AREA -->
<div class="container">
<?
	//Determina se caricare il calendario o la pagina di inserimento/modifica evento. Default: calendario
	$status = getVal('status');

	switch($status):

			case "":

				include_once(DIR_MOD . 'calendar.php');

			break;

			case "ins": case "mod":

				include_once(DIR_MOD . 'event.php');

			break;

	endswitch;


?>
</div>
<!-- END CONTENT AREA -->

<!-- TEMPLATE FOOTER -->
<?php include_once(DIR_ROOT . 'template/footer.php'); ?>
<!--------------------->
