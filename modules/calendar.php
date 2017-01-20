<?php

  $getTime = getVal('time'); //Timestap to se the actual position in the calendar navigation
  $timeDir = getVal('dir'); //Calendar navigation direction
  $timeNav =  dateNavigation($getTime,$timeDir,""); //Calendar navigation function call --> php/functions.php

  $getGroup = getVal('group'); //Id of the calendar group shown
  if($getGroup != ''):
    $idGroup = $getGroup;
  else:
    $recordTopGroup = gmGetter("calendario_gruppo","ORDER BY posizione ASC LIMIT 0,1","AND lingua_riferimento='".$linguaCms."'");
    $idGroup = $recordTopGroup[0]['id']; //Default: the first calendar group displayed is the first on position ASC
  endif;

  $startToday = '0-0-0-' . date('j-n-Y');
  $timeStartToday = date2Time($startToday);

  $thisMonth = date("n",$timeNav);
  $thisMonthLenght = date("t",$timeNav);
  $thisYear = date("Y",$timeNav);

  $timeFirstDayThisMonth = mktime(0,0,0,$thisMonth,1,$thisYear);
  $timeLastDayThisMonth = mktime(23,59,0,$thisMonth,$thisMonthLenght,$thisYear);

  $weekPosFirstDayThisMonth = date("N",$timeFirstDayThisMonth);
  $weekPosLastDayThisMonth = date("N",$timeLastDayThisMonth);


  $recordGroups = gmGetter("calendario_gruppo","ORDER BY posizione ASC","AND lingua_riferimento='".$linguaCms."'");
  $countRecordGroups = count($recordGroups);

?>


<div id="calendarBox">


    <div class="row">

      <!-- GROUPS LIST-->

      <div class="col-sm-2">

        <div class="side-navigation">

          <h2>Gruppi</h2>

          <div class="row">

            <?php
              if($countRecordGroups > 0):
                foreach($recordGroups as $group):
                  if($group['id'] == $idGroup):
                    $activeGroup = "active-group";
                  else:
                    $activeGroup = "";
                  endif;
            ?>

                    <a href="<?php echo DIR_SELF.'?group='.$group['id']."&time=".$timeNav; ?>" class="btn col-sm-12 col-xs-3 <? echo $activeGroup; ?>"><p><? echo $group['titolo'.$linguaCms]; ?></p></a>

            <?php
                endforeach;
              endif;
            ?>

          </div>

        </div>

      </div>

      <!-- END GROUPS LIST-->


      <div class="col-sm-10">

          <div class="row">

            <div class="date-navigation">

              <div class="row">
                <a href="<?php echo DIR_SELF.'?time=&group='.$idGroup; ?>" class="btn col-sm-1"><span>Oggi</span></a>

                <a href="<?php echo DIR_SELF.'?time='.$timeNav.'&dir=y_prev&group='.$idGroup; ?>" class="btn col-sm-1"><i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i></a>

                <a href="<?php echo DIR_SELF.'?time='.$timeNav.'&dir=prev&group='.$idGroup; ?>" class="btn col-sm-1"><i class="fa fa-chevron-left"></i></a>

                <div id="dateDisplay" class="col-sm-3 col-xs-3">
                    <h2><? echo $dateSet['month'][$thisMonth] ." ". $thisYear; ?></h2>
                </div>

                <a href="<?php echo DIR_SELF.'?time='.$timeNav.'&dir=next&group='.$idGroup; ?>" class="btn col-sm-1"><i class="fa fa-chevron-right"></i></a>

                <a href="<?php echo DIR_SELF.'?time='.$timeNav.'&dir=y_next&group='.$idGroup; ?>" class="btn col-sm-1"><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a>

              </div>

            </div>

          </div>

          <div class="grid-wrapper">

              <div class="row">

                  <?php
                    for($i = 1; $i <= 7; $i++):
                      $labelWeekDay =$dateSet['weekDay'][$i]; // dateTranslate($i,"weekDay",$lang); //;
                  ?>

                    <div class="col-fixed-7 col-cell-th">
                        <p><? echo $labelWeekDay; ?></p>
                    </div>

                  <?php
                    endfor;
                  ?>

              </div>

              <div class="row">

              <?php
                for($emptyDay = 1; $emptyDay < $weekPosFirstDayThisMonth; $emptyDay++):
              ?>
                  <div class="col-fixed-7 col-cell-empty">
                    &nbsp;
                  </div>
              <?php
                endfor;
              ?>


              <?php
                for($thisDay = 1; $thisDay <= $thisMonthLenght; $thisDay++):
                  $timeStartThisDay= mktime(0,0,0,$thisMonth,$thisDay,$thisYear);
                  $timeEndThisDay= mktime(23,59,59,$thisMonth,$thisDay,$thisYear);

                  if($timeStartThisDay == $timeStartToday):
                    $markToday = "highlight";
                  else:
                    $markToday = "";
                  endif;

                  $recordEvents = gmGetter("calendario_evento","WHERE id_gruppo='".$idGroup."' AND
                  (((data_inizio < '".$timeStartThisDay."') AND (data_fine > '".$timeEndThisDay."')) OR
                  (data_inizio BETWEEN '".$timeStartThisDay."' AND '".$timeEndThisDay."') OR (data_fine BETWEEN '".$timeStartThisDay."' AND '".$timeEndThisDay."'))
                  ORDER BY data_inizio ASC","AND lingua_riferimento='".$linguaCms."'");

                  $countRecordEvents = count($recordEvents);

              ?>

                  <div class="col-fixed-7 col-cell-td">
                      <div class="col-cell-cont <? echo $markToday; ?>">

                          <p><? echo $thisDay; ?></p>

                          <a href="<? echo DIR_SELF.'?status=ins&start='.$timeStartThisDay.'&end='.$timeEndThisDay.'&group='.$idGroup; ?>" class="col-cell-select"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i></a>

                      </div>

                      <!-- DAY EVENTS -->
                      <?php
                        if($countRecordEvents > 0):
                          foreach($recordEvents as $event):
                              $startThisEvent = date("H:i",$event['data_inizio']);
                              $endThisEvent = date("H:i",$event['data_fine']);

                              $dateEndThisEvent = date("j-n-Y",$event['data_fine']);
                              $dateEndThisEvent = "23-59-0-".$dateEndThisEvent;
                              $timeWholeDayCheck = date2Time($dateEndThisEvent);

                              if( (($event['data_inizio'] >= $timeStartThisDay) && ($event['data_inizio'] <= $timeEndThisDay)) && (($event['data_fine'] >= $timeStartThisDay) && ($event['data_fine'] <= $timeEndThisDay)) ):
                      ?>

                                  <a href="<?php echo DIR_SELF.'?status=mod&event='.$event['id']; ?>" class="event-row" style="background-color:<? echo $event['colore']; ?>;">
                                    <span class="event-cont">
                                      <span class="event-lab event-start">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <? echo $startThisEvent; ?>
                                      </span>
                                      <span class="event-lab event-name">
                                        <? echo $event['titolo'.$linguaCms]; ?>
                                      </span>
                                      <span class="event-lab event-end">
                                        <?
                                          if($event['data_fine'] == $timeWholeDayCheck):
                                            echo '<i class="fa fa-circle-o-notch" aria-hidden="true"></i>';
                                          else:
                                            echo '<i class="fa fa-clock-o" aria-hidden="true"></i> ' . $endThisEvent;
                                          endif;
                                        ?>
                                      </span>
                                    </span>
                                  </a>

                      <?php
                              elseif((($event['data_inizio'] >= $timeStartThisDay) && ($event['data_inizio'] <= $timeEndThisDay)) && ($event['data_fine'] > $timeEndThisDay)):
                      ?>

                                  <a href="<?php echo DIR_SELF.'?status=mod&event='.$event['id']; ?>" class="event-row" style="background-color:<? echo $event['colore']; ?>;">
                                    <span class="event-cont">
                                      <span class="event-lab event-start">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <? echo $startThisEvent; ?>
                                      </span>
                                      <span class="event-lab event-name">
                                        <? echo $event['titolo'.$linguaCms]; ?>
                                      </span>
                                      <span class="event-lab event-end">
                                        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                      </span>
                                    </span>
                                  </a>

                        <?php
                              elseif(($event['data_inizio'] < $timeStartThisDay) && (($event['data_fine'] >= $timeStartThisDay) && ($event['data_fine'] <= $timeEndThisDay))):
                        ?>

                                  <a href="<?php echo DIR_SELF.'?status=mod&event='.$event['id']; ?>" class="event-row" style="background-color:<? echo $event['colore']; ?>;">
                                    <span class="event-cont">
                                        <span class="event-lab event-start">
                                          <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                                        </span>
                                        <span class="event-lab event-name">
                                          <? echo $event['titolo'.$linguaCms]; ?>
                                        </span>
                                        <span class="event-lab event-end">
                                          <?
                                            if($event['data_fine'] == $timeWholeDayCheck):
                                              echo '<i class="fa fa-circle-o-notch" aria-hidden="true"></i>';
                                            else:
                                              echo '<i class="fa fa-clock-o" aria-hidden="true"></i> ' . $endThisEvent;
                                            endif;
                                          ?>
                                        </span>
                                    </span>
                                  </a>

                        <?php
                              elseif(($event['data_inizio'] < $timeStartThisDay) && ($event['data_fine'] > $timeEndThisDay)):
                        ?>

                                    <a href="<?php echo DIR_SELF.'?status=mod&event='.$event['id']; ?>" class="event-row" style="background-color:<? echo $event['colore']; ?>;">
                                        <span class="event-cont">
                                            <span class="event-lab event-start">
                                              <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                                            </span>
                                            <span class="event-lab event-name">
                                              <? echo $event['titolo'.$linguaCms]; ?>
                                            </span>
                                            <span class="event-lab event-end">
                                                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                            </span>
                                        </span>
                                    </a>

                      <?php
                            endif;
                          endforeach;
                        endif;
                      ?>

                      <!-- END DAY EVENTS -->


                  </div>

              <?php
                  unset($recordEvents);
                endfor;
              ?>


              <?php
                for($emptyDay = $weekPosLastDayThisMonth; $emptyDay < 7; $emptyDay++):
              ?>
                  <div class="col-fixed-7 col-cell-empty">
                    &nbsp;
                  </div>
              <?php
                endfor;
              ?>


            </div>

        </div>


        <?php
          $recordEventsList = gmGetter("calendario_evento","WHERE id_gruppo='".$idGroup."' AND
          ((data_inizio BETWEEN '".$timeFirstDayThisMonth."' AND '".$timeLastDayThisMonth."') OR
          (data_fine BETWEEN '".$timeFirstDayThisMonth."' AND '".$timeLastDayThisMonth."') OR
          ((data_inizio < '".$timeFirstDayThisMonth."') AND (data_fine > '".$timeLastDayThisMonth."')))
          ORDER BY data_inizio ASC","AND lingua_riferimento='".$linguaCms."'");

          $countRecordEventsList = count($recordEventsList);
        ?>

        <!-- MONTHLY EVENTS LIST -->

        <div id="eventsList">

          <div class="row">

            <h2>Lista Eventi</h2>

            <div class="h20"></div>

            <?php
              if($countRecordEventsList > 0):
                foreach($recordEventsList as $listRow):
                  $startThisEvent = date("j/n/Y - H:i",$listRow['data_inizio']);
                  $endThisEvent = date("j/n/Y - H:i",$listRow['data_fine']);

                  $dateEndThisEvent = date("j-n-Y",$listRow['data_fine']);
                  $dateEndThisEvent = "23-59-0-".$dateEndThisEvent;
                  $timeWholeDayCheck = date2Time($dateEndThisEvent);

                  $thisEventTitle = db2Text($listRow['titolo'.$linguaCms]);
                  $thisEventNotes = db2Text($listRow['testo'.$linguaCms]);
                  $thisEventColor = $listRow['colore'];
            ?>

                    <a href="<?php echo DIR_SELF.'?status=mod&event='.$listRow['id']; ?>" class="flow_box col-lg-8" style="background-color:<? echo $thisEventColor; ?>;">
                        <span class="flow_row">
                          <h4><i class="fa fa-clock-o" aria-hidden="true"></i> Inizio: <? echo $startThisEvent; ?></h4>
                          <?php
                              if($listRow['data_fine'] == $timeWholeDayCheck):
                          ?>
                                <h4><i class="fa fa-circle-o-notch" aria-hidden="true"></i> Fine: <? echo date("j/n/Y",$listRow['data_fine']); ?> - Tutto il giorno</h4>
                          <?php
                              else:
                          ?>
                                <h4><i class="fa fa-clock-o" aria-hidden="true"></i> Fine: <? echo $endThisEvent; ?></h4>

                          <?php endif; ?>

                        </span>

                        <h3><? echo $thisEventTitle; ?></h3>
                        <h4>Note:</h4>
                        <p><? echo $thisEventNotes; ?></p>
                    </a>

            <?php
                endforeach;
              endif;
            ?>

          </div>

        </div>

      </div>

    </div>


</div>

<script type="text/javascript">

  var thisYear = '';
  var thisMonth = '';
  var thisDay = '';

</script>
