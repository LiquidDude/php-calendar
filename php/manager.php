<?
require_once('connection.php');
require_once('functions.php');
$nlFor = 2;

switch ($_POST['status']):
case "ins":

/* ================================================
  _____                     _          _
 |_   _|                   (_)        (_)
   | |  _ __  ___  ___ _ __ _ ___  ___ _
   | | | '_ \/ __|/ _ \ '__| / __|/ __| |
  _| |_| | | \__ \  __/ |  | \__ \ (__| |
 |_____|_| |_|___/\___|_|  |_|___/\___|_|


 Insert
================================================ */

$timeStartEvent = mktime($_POST['hourStartDate'],$_POST['minuteStartDate'],0,$_POST['monthStartDate'],$_POST['dayStartDate'],$_POST['yearStartDate']);
$timeEndEvent = mktime($_POST['hourEndDate'],$_POST['minuteEndDate'],0,$_POST['monthEndDate'],$_POST['dayEndDate'],$_POST['yearEndDate']);

//INSTERT NEW EVENT INTO TABLE calendario_evento
$field['id']="''";
$field['id_gruppo']="'".$_POST['group']."'";
$field['id_link']="''";
$field['data_inizio']="'".$timeStartEvent."'";
$field['data_fine']="'".$timeEndEvent."'";
$field['colore']="'".$_POST['color']."'";

$stringKeys=join(",",array_keys($field));
$stringValues=join(",",array_values($field));

$queryInsertEvent=mysql_query("INSERT INTO calendario_evento (".$stringKeys.") VALUES (".$stringValues.")",$connessione);
$idRecord=mysql_insert_id();


//INSTERT NEW EVENT INTO TABLE calendario_evento_t

for ($i=1; $i<$nlFor; $i++):

  $lRif = 'L'.$i;
  $detField = array(
                    "titolo" => PostVal('titolo'.$lRif),
                    "testo" => PostVal('testo'.$lRif)
                    );


  foreach($detField as $field => $text):

      if ($text != ''):

          $field_t['id']="''";
          $field_t['id_concat']="'".$idRecord."'";
          $field_t['lingua_riferimento']="'".$lRif."'";
          $field_t['campo']="'".$field."'";
          $field_t['testo']="'".text2db($text)."'";

          $stringField_t=join(",",$field_t);
          $queryInsertField_t=mysql_query("INSERT INTO calendario_evento_t VALUES (".$stringField_t.")",$connessione);

          unset($stringField_t);
      		unset($field_t);

      endif;

  endforeach;

  unset($detField);

endfor;

header("location:../index.php?time=".$timeStartEvent."&group=".$_POST['group']."");

break;


case "mod":

/* ================================================
  __  __           _ _  __ _
 |  \/  |         | (_)/ _(_)
 | \  / | ___   __| |_| |_ _  ___ __ _
 | |\/| |/ _ \ / _` | |  _| |/ __/ _` |
 | |  | | (_) | (_| | | | | | (_| (_| |
 |_|  |_|\___/ \__,_|_|_| |_|\___\__,_|

      Update
================================================ */

//UPDATE NEW EVENT INTO TABLE calendario_evento
$timeStartEvent = mktime($_POST['hourStartDate'],$_POST['minuteStartDate'],0,$_POST['monthStartDate'],$_POST['dayStartDate'],$_POST['yearStartDate']);
$timeEndEvent = mktime($_POST['hourEndDate'],$_POST['minuteEndDate'],0,$_POST['monthEndDate'],$_POST['dayEndDate'],$_POST['yearEndDate']);

$field[]="id='".$_POST['event']."'";
$field[]="id_gruppo='".$_POST['group']."'";
$field[]="id_link=''";
$field[]="data_inizio='".$timeStartEvent."'";
$field[]="data_fine='".$timeEndEvent."'";
$field[]="colore='".$_POST['color']."'";

$stringEvent=join(",",$field);
$queryUpdateEvent=mysql_query("UPDATE calendario_evento SET ".$stringEvent." WHERE id='".$_POST['event']."'",$connessione);


//UPDATE NEW EVENT INTO TABLE calendario_evento_t

/* ============ AUXILIARY TABLE UPDATE FUNCTION ============== */
//The auxiliary table is where the text and notes associated to an event are stored. This way thanks to the column 'lingua_riferimento' it's possible to have support for other auxiliary languages.

function updateRecord_t($tabella_t,$idConcat,$campo,$testo,$i){

    global $connessione;

    if ($i==''):
      $trovaRiga="WHERE (id_concat='".$idConcat."' AND campo='".$campo."')";
    else:
      $trovaRiga="WHERE (id_concat='".$idConcat."' AND campo='".$campo."' AND lingua_riferimento='L".$i."')";
    endif;

    // Update existing record

    $queryIns_t=mysql_query("SELECT id FROM ".$tabella_t." ".$trovaRiga." LIMIT 1",$connessione);

    if (mysql_num_rows($queryIns_t)>0):
      $update=mysql_query("UPDATE ".$tabella_t." SET testo='".$testo."' ".$trovaRiga." ",$connessione);
    else:
    // Add new record

    		$campo_t['id']="''";
    		$campo_t['id_concat']="'".$idConcat."'";

    		if ($i==''):
    		    $campo_t['lingua_riferimento']="''";
    		else:
    		    $campo_t['lingua_riferimento']="'L".$i."'";
    		endif;

    		$campo_t['campo']="'".$campo."'";
    		$campo_t['testo']="'".$testo."'";

    		$stringa_t=join(",",$campo_t);
    		$query=mysql_query("INSERT INTO ".$tabella_t." VALUES (".$stringa_t.")",$connessione);

    endif;
}
/* ============ ==================================== ============== */


$table_t='calendario_evento_t';

for ($i=1; $i<$nlFor; $i++):

  $lRif = 'L'.$i;
  $detField = array(
                    "titolo" => PostVal('titolo'.$lRif),
                    "testo" => PostVal('testo'.$lRif)
                    );

  foreach($detField as $field => $text):

      if ($text != ''):
	       $queryUpdateEvent_t = updateRecord_t($table_t,$_POST['event'],$field,text2db($text),$i);
	    endif;

  endforeach;

  unset($detField);

endfor;


header("location:../index.php?time=".$timeStartEvent."&group=".$_POST['group']."");


break;



case "del":
/* ====================================================
   _____                     _ _
  / ____|                   | | |
 | |     __ _ _ __   ___ ___| | | __ _
 | |    / _` | '_ \ / __/ _ \ | |/ _` |
 | |___| (_| | | | | (_|  __/ | | (_| |
  \_____\__,_|_| |_|\___\___|_|_|\__,_|

    Delete
==================================================== */
$recordEvent = gmGetter("calendario_evento","WHERE id='".$_POST['event']."' LIMIT 0,1");
$groupEvent = $recordEvent[0]['id_gruppo'];
$timeStartEvent = $recordEvent[0]['data_inizio'];

$queryDeleteEvent=mysql_query("DELETE FROM calendario_evento WHERE id='".$_POST['event']."'",$connessione);
$queryDeleteEventT=mysql_query("DELETE FROM calendario_evento_t WHERE id_concat='".$_POST['event']."'",$connessione);

header("location:../index.php?time=".$timeStartEvent."&group=".$groupEvent."");

break;
endswitch;

mysql_close($connessione);
?>
