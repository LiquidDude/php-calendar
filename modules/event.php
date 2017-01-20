<?php
//Event colors palette: add hex code to the array to add new color to the selection
$eventColors = array("#9fc6e7","#2e84c1","#a4bdfc","#46d6db","#7ae7bf","#51b749","#fbd75b","#ffb878","#ff887c","#dc2127","#dbadff","#e1e1e1");

switch($status):

  case "ins":
    $group = getVal('group');
    $timeStartThisDay = getVal('start');
    $timeEndThisDay = getVal('end');

    $timeSetCalendar = $timeStartThisDay;

    $thisMinute = date("i",$timeStartThisDay);
    $thisHour = date("G",$timeStartThisDay);
    $thisDay = date("j",$timeStartThisDay);
    $thisMonth = date("n",$timeStartThisDay);
    $thisYear = date("Y",$timeStartThisDay);
?>
    <script type="text/javascript">

      var startYear = '<? echo $thisYear; ?>';
      var startMonth = '<? echo $thisMonth; ?>';
      var startDay = '<? echo $thisDay; ?>';

      var endYear = '<? echo $thisYear; ?>';
      var endMonth = '<? echo $thisMonth; ?>';
      var endDay = '<? echo $thisDay; ?>';

    </script>
<?

  break;

  case "mod":

    $idEvent = getVal('event');
    $recordEvent = gmGetter("calendario_evento","WHERE id='".$idEvent."' LIMIT 0,1","AND lingua_riferimento='".$linguaCms."'");
    $timeStartEvent = $recordEvent[0]['data_inizio'];
    $timeEndEvent = $recordEvent[0]['data_fine'];
    $thisEventTitle = db2Text($recordEvent[0]['titolo'.$linguaCms]);
    $thisEventNotes = db2Text($recordEvent[0]['testo'.$linguaCms]);
    $thisEventColor = $recordEvent[0]['colore'];
    $group = $recordEvent[0]['id_gruppo'];

    $timeSetCalendar = $timeStartEvent;

    $startDay = date("j",$timeStartEvent);
    $startMonth = date("n",$timeStartEvent);
    $startYear = date("Y",$timeStartEvent);
    $startHour = date("G",$timeStartEvent);
    $startMinute = date("i",$timeStartEvent);

    $endDay = date("j",$timeEndEvent);
    $endMonth = date("n",$timeEndEvent);
    $endYear = date("Y",$timeEndEvent);
    $endHour = date("G",$timeEndEvent);
    $endMinute = date("i",$timeEndEvent);

?>
    <script type="text/javascript">

        var startYear = '<? echo $startYear; ?>';
        var startMonth = '<? echo $startMonth; ?>';
        var startDay = '<? echo $startDay; ?>';

        var endYear = '<? echo $endYear; ?>';
        var endMonth = '<? echo $endMonth; ?>';
        var endDay = '<? echo $endDay; ?>';

    </script>
<?

  break;

endswitch;
?>

<div id="formBox">

  <form id="eventForm" method="post" action="<? echo DIR_PHP; ?>manager.php">

    <div class="row form-block">

      <div class="col-lg-5 form-row">

          <div class="row">

              <div class="col-md-2"><h2>Inizio evento</h2></div>

              <div class="col-sm-1 col-xs-2 form-block">
                  <select id="dayStartDate" name="dayStartDate" class="form-select">
		              </select>
              </div>

              <div class="col-sm-3 col-xs-4 form-block">
                  <select id="monthStartDate" name="monthStartDate" class="form-select">
                    <?php
                      for($i = 1; $i <= 12; $i++):
                        $month = $dateSet['month'][$i];
                    ?>
                          <option value="<? echo $i;?>"><? echo $month;?></option>
                    <?php
                      endfor;
                    ?>

		              </select>
              </div>

              <div class="col-xs-2 form-block">
                  <select id="yearStartDate" name="yearStartDate" class="form-select">
		              </select>
              </div>

              <div class="col-xs-1 form-block">
                  <select id="hourStartDate" name="hourStartDate" class="form-select">
                    <?php
                      for($i = 0; $i <= 23; $i++):
                        if(isset($startHour)):
                          if($i == $startHour):
                            $selected = 'selected="selected"';
                          else:
                            $selected = '';
                          endif;
                        endif;
                    ?>
                        <option value="<? echo $i;?>" <? echo $selected; ?>><? echo $i;?></option>
                    <?php
                      endfor;
                    ?>
		              </select>
              </div>

              <div class="col-xs-1 form-block">
                  <select id="minuteStartDate" name="minuteStartDate" class="form-select">

                    <?php
                      for($i = 0; $i <= 59; $i++):
                        if($i < 10):
                          $i = "0" . $i;
                        endif;

                        if(isset($startMinute)):
                          if($i == $startMinute):
                            $selected = 'selected="selected"';
                          else:
                            $selected = '';
                          endif;
                        endif;
                    ?>
                        <option value="<? echo $i;?>" <? echo $selected; ?>><? echo $i;?></option>
                    <?php
                      endfor;
                    ?>
		              </select>
              </div>

          </div>

      </div>

      <div class="col-lg-5 form-row">

          <div class="row">

              <div class="col-md-2"><h2>Fine evento</h2></div>

              <div class="col-sm-1 col-xs-2 form-block">
                  <select id="dayEndDate" name="dayEndDate" class="form-select">
                  </select>
              </div>

              <div class="col-sm-3 col-xs-4 form-block">
                  <select id="monthEndDate" name="monthEndDate" class="form-select">

                    <?php
                      for($i = 1; $i <= 12; $i++):
                        $month = $dateSet['month'][$i];
                    ?>
                          <option value="<? echo $i;?>"><? echo $month;?></option>
                    <?php
                      endfor;
                    ?>

                  </select>
              </div>

              <div class="col-xs-2 form-block">
                  <select id="yearEndDate" name="yearEndDate" class="form-select">
                  </select>
              </div>

              <div class="col-xs-1 form-block">
                  <select id="hourEndDate" name="hourEndDate" class="form-select">
                    <?php
                      for($i = 0; $i <= 23; $i++):
                        if(isset($endHour)):
                          if($i == $endHour):
                            $selected = 'selected="selected"';
                          else:
                            $selected = '';
                          endif;
                        endif;
                    ?>
                        <option value="<? echo $i;?>" <? echo $selected; ?>><? echo $i;?></option>
                    <?php
                      endfor;
                    ?>
		              </select>
              </div>

              <div class="col-xs-1 form-block">
                  <select id="minuteEndDate" name="minuteEndDate" class="form-select">
                    <?php
                      for($i = 0; $i <= 59; $i++):
                        if($i < 10):
                          $i = "0" . $i;
                        endif;

                        if(isset($endMinute)):
                          if($i == $endMinute):
                            $selected = 'selected="selected"';
                          else:
                            $selected = '';
                          endif;
                        endif;
                    ?>
                        <option value="<? echo $i;?>" <? echo $selected; ?>><? echo $i;?></option>
                    <?php
                      endfor;
                    ?>
		              </select>
              </div>

          </div>

      </div>

      <div class="col-lg-2 form-row">
        <a heref="#" id="btnWholeDay" class="btn"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> Tutto il giorno</a>
      </div>

    </div>



    <div class="row form-row">

      <div class="col-md-1"><label for="eventName"><h2>Nome evento</h2></label></div>

      <div class="col-md-6">

        <input id="titolo<? echo $linguaCms; ?>" name="titolo<? echo $linguaCms; ?>" class="form-input" value="<? echo $thisEventTitle; ?>" />

      </div>

    </div>

    <div class="row form-row">

      <div class="col-md-1"><label for="eventName"><h2>Note</h2></label></div>

      <div class="col-md-6">

        <textarea id="testo<? echo $linguaCms; ?>" name="testo<? echo $linguaCms; ?>" class="form-textarea"><? echo $thisEventNotes; ?></textarea>

      </div>

    </div>

    <div class="row form-row">

      <div class="col-md-1"><label for="eventName"><h2>Colore</h2></label></div>

      <div class="col-md-6">

      <?php
        foreach($eventColors as $key => $color):
          if(isset($thisEventColor)):
              if($color == $thisEventColor):
                $colorChecked = 'checked';
                $colorActive = 'color-selected';
              else:
                $colorChecked = '';
                $colorActive = '';
              endif;
          else:
              if($color == "#9fc6e7"):
                $colorChecked = 'checked';
                $colorActive = 'color-selected';
              else:
                $colorChecked = '';
                $colorActive = '';
              endif;
          endif;
      ?>

          <div class="radio-block">
            <input type="radio" id="color<?php echo $key; ?>" class="hide-radio" name="color" value="<?php echo $color; ?>" <? echo $colorChecked; ?> /><label for="color<?php echo $key; ?>"><span id="bgColor<?php echo $key;?>" class="color_label <?php echo $colorActive; ?>" style="background-color:<?php echo $color; ?>;">&nbsp;</span></label>
          </div>

      <?php endforeach; ?>


      </div>

    </div>


    <?php
      switch($status):

        case "ins":
    ?>
          <div class="row form-row">

            <input type="hidden" name="status" value="<? echo $status; ?>" />

            <input type="hidden" name="group" value="<? echo $group; ?>" />

            <input type="hidden" name="lang" value="<? echo $linguaCms; ?>" />

            <button form="eventForm" type="submit" class="btn submit-btn"><i class="fa fa-check" aria-hidden="true"></i> Crea evento</button>

          </div>

        </form>

    <?php
        break;

        case "mod":
    ?>
          <div class="row form-row">

            <input type="hidden" name="status" value="<? echo $status; ?>" />

            <input type="hidden" name="group" value="<? echo $group; ?>" />

            <input type="hidden" name="event" value="<? echo $idEvent; ?>" />

            <button form="eventForm" type="submit" class="btn submit-btn"><i class="fa fa-check" aria-hidden="true"></i> Modifica evento</button>

          </div>

        </form>

        <form id="deleteForm" method="post" action="<? echo DIR_PHP; ?>manager.php">

          <div class="row form-row">

            <input type="hidden" name="status" value="del" />

            <input type="hidden" name="event" value="<? echo $idEvent; ?>" />

            <button form="deleteForm" type="submit" class="btn submit-btn"><i class="fa fa-times" aria-hidden="true"></i> Elimina evento</button>

          </div>

        </form>

    <?php
        break;

      endswitch;
    ?>


    <div class="row form-row">

      <a href="<?php echo DIR_SELF.'?time='.$timeSetCalendar.'&group='.$group; ?>" class="btn"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Annulla</a>

    </div>



</div>
