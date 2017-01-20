<?php

/*==============================*/
/*========= GET & POST =========*/
/*=============================*/

		function GetVal($name)
		{
			$value = '';
			if(isset($_GET[$name]))
			{
				$value = $_GET[$name];
			}
			return $value;
		}


		function PostVal($name)
		{
			$value='';
			if(isset($_POST[$name]))
			{
				$value = $_POST[$name];
			}
			return $value;
		}


/*===================================*/
/*========= DATABASE QUERY =========*/
/*==================================*/

		function getRecordItem($sSql)
		{
			global $connessione;

			$ret=mysql_query($sSql, $connessione);
			$nRet=mysql_num_rows($ret);
			if ($nRet > 0)
			{
				$record=mysql_fetch_assoc($ret);
			}

			return $record;
		}


		function getRecordList($sSql)
		{
			global $connessione;

			$res=mysql_query($sSql, $connessione);
			while($record=mysql_fetch_assoc($res))
			{
					$arrayRecord[]=$record;
			}
			return $arrayRecord;
		}


/*===================================*/
/*========== FILES SCANNER =========*/
/*==================================*/

		function scanFiles($directory,$ext)
		{
				if (glob($directory."*".$ext) != false) {
						$filelist = glob($directory."*".$ext);
						return $filelist;
				} else {
						return $filelist='';
				}
		}

/*===================================*/
/*========== STRING CHECK ==========*/
/*==================================*/

			function text2Db($stringa){
				if ($stringa=='<p><br></p>' || $stringa=='<br>'): $stringa=''; endif;
				$stringa = strip_tags($stringa);
				$stringa = str_replace('"', "&quot;", $stringa);
				$stringa = addslashes($stringa);
				$stringa = trim($stringa);
				return $stringa;
			}


			function db2Text($stringa){
				$stringa = stripslashes($stringa);
				$stringa = trim($stringa);
				return $stringa;
			}


/*===================================*/
/*========== DATE MANAGER ==========*/
/*==================================*/

			function dateNavigation($getTime,$timeDir,$day)
			{
				if(($getTime != '')):

						if($timeDir != ''):

								switch($timeDir):

										case "prev":
											return $timeNav=strtotime('-1 month', $getTime);
										break;

										case "next":
											return $timeNav=strtotime('+1 month', $getTime);
										break;

										case "y_next":
											return $timeNav=strtotime('+1 year', $getTime);
										break;

										case "y_prev":
											return $timeNav=strtotime('-1 year', $getTime);
										break;

								endswitch;

							else:

								return $timeNav = $getTime;

							endif;

				else:

						if($day != ''):

							return $timeNav = $day;

						else:

							$monthToday=date('n',time());
							$yearToday=date('Y',time());
							return $timeNav=mktime(0,0,0,$monthToday,1,$yearToday);

						endif;

				endif;
			}


			function date2Time($strDate){
				if($strDate!=""):
					$rsl = explode ('-',$strDate);
					$rsl = mktime($rsl[0],$rsl[1],$rsl[2],$rsl[4],$rsl[3],$rsl[5]);
					return $rsl;
				endif;
			}

/*
			function dateTranslate($dateValue,$dateType,$lang)
			{
				//global $lang;
				if(isset($lang)):
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

					$dateName = $dateSet[$dateType][$dateValue];

					return = "$dateName";
				endif;
			}
*/



/* ================================
GM GETTER - Function to retrieve data from the main a table and associate the data with the related auxiliary table. It returns a two dimensions array with all the data requested.
================================ */

function gmGetter($tabella,$filtro,$filtro_t,$n){
		global $connessione;

		$i=0;

		$recordAux=array();
		$query=mysql_query("SELECT * FROM ".$tabella." ".$filtro."");

		$checkTable=mysql_query("SELECT 1 FROM ".$tabella."_t LIMIT 1");

		while($record=mysql_fetch_assoc($query)):
		  if($checkTable!==FALSE):

			  $query_t=''; $record_a=''; $nuova_riga='';
			  $query_t=mysql_query("SELECT lingua_riferimento,campo,testo FROM ".$tabella."_t WHERE id_concat=".$record['id']." ".$filtro_t."");
			  $num_rows=mysql_num_rows($query_t);

		      if ($num_rows>0):
		      while($record_t=mysql_fetch_assoc($query_t)):
		      $record_a[$record_t['campo'].$record_t['lingua_riferimento']]="".$record_t['testo']."";
		        foreach($record_a as $colonna => $valore):
		        $nuova_riga[$colonna]=$valore;
		        endforeach;
		      $recordAux[$i]=array_merge($record,$nuova_riga);
		      endwhile;
		      else:
		      $recordAux[$i]=$record;
		      endif;
		  else:
		  $recordAux[$i]=$record;
		  endif;

			$i++;

		endwhile;
return $recordAux;
}
