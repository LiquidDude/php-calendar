function onLoad(){

      loadDateSelector(startYear,startMonth,startDay,'StartDate');
      loadDateSelector(endYear,endMonth,endDay,'EndDate');
      $("#eventForm").on('submit',checkSubmit);
      clickMark('.color_label','color-selected');
      setWholeDay('#btnWholeDay');

  }

  


function clickMark(item,activeClass)
{
    $(item).click(function(){
      var thisItem = $(this);
      $(item).not(thisItem).removeClass(activeClass);
      thisItem.addClass(activeClass);
    });
}


  function loadDateSelector(setYear,setMonth,setDay,idName){
				var today = new Date();
				$("#month"+ idName).val(setMonth);
				$("#month"+ idName + ",#year"+ idName).on('change',loadDay);
        $("#day"+ idName + ",#month"+ idName + ",#year"+ idName + ",#hour"+ idName+ ",#minute"+ idName).on('change',checkDates);

        //Fills days selection
				function loadDay()
				{
          var lastSetDay = $("#day"+ idName).val();
          console.log(lastSetDay);
					var thisMonth = $("#month"+ idName).val();
					var thisYear = $("#year"+ idName).val();
					var maxDays = new Date(thisYear,thisMonth,0).getDate();
					$("#day"+ idName).empty();
					for(var day = 1; day <= maxDays; day++)
					{
						var selected = "";

            if(lastSetDay == null)
            {
  						if(day == setDay)
  						{
  							selected = 'selected="selected"';
  						}
            } else {
              if(day == lastSetDay)
  						{
  							selected = 'selected="selected"';
  						}
            }

						$("#day"+ idName).append('<option ' + selected + ' value="' + day + '">' + day +  '</option>');
					}
				}


				//Fills years selections
				for(var year = today.getFullYear()-1; year < (today.getFullYear()+15); year++)
				{
					var selected = "";
					if(year==setYear)
					{
						selected = 'selected="selected"';
					}
					$("#year"+ idName).append('<option ' + selected + ' value="' + year + '">' + year +  '</option>');
				}

				loadDay();

		}

function checkDates()
{
      $("#dayEndDate" + ",#monthEndDate" + ",#yearEndDate" + ",#hourEndDate" + ",#minuteEndDate").css("background-color","");
      var dateError = 0;

      var dayStartDate = $("#dayStartDate").val();
      var monthStartDate = $("#monthStartDate").val() - 1;
      var yearStartDate = $("#yearStartDate").val();
      var hourStartDate = $("#hourStartDate").val();
      var minuteStartDate = $("#minuteStartDate").val();

      var dayEndDate = $("#dayEndDate").val();
      var monthEndDate = $("#monthEndDate").val() - 1;
      var yearEndDate = $("#yearEndDate").val();
      var hourEndDate = $("#hourEndDate").val();
      var minuteEndDate = $("#minuteEndDate").val();

      var startDate = new Date(yearStartDate, monthStartDate, dayStartDate, hourStartDate, minuteStartDate);
      var endDate = new Date(yearEndDate, monthEndDate, dayEndDate, hourEndDate, minuteEndDate);

      if(startDate > endDate)
      {
          $("#dayEndDate" + ",#monthEndDate" + ",#yearEndDate" + ",#hourEndDate" + ",#minuteEndDate").css("background-color","#fff0f0");
          dateError = 1;
      }

      return dateError;

}


function checkSubmit(event)
{
  var dateError = checkDates();

  if(dateError == 0)
  {

  } else if(dateError == 1) {
    alert("La data di fine evento è precedente a quella di inizio");
    event.preventDefault();
  }

}

function setWholeDay(item)
{
  $(item).click(function(){
      $('#hourEndDate').find('option:selected').removeAttr("selected");
      $('#minuteEndDate').find('option:selected').removeAttr("selected");
      $('#hourEndDate option[value=23]').prop('selected',true);
      $('#minuteEndDate option[value=59]').prop('selected',true);
      checkDates();
      return false;
  });
}


  $(document).ready(onLoad);

  $(window).bind("load", function() {});

  $(window).bind('scroll', function() {});

  $(window).bind("resize", function() {});
