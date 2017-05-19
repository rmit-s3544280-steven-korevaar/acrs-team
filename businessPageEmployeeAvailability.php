<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 * PHP script to generate the page for business owner display employee
 * work period.
 * Uses a plugin from FullCalendar.io.
 * 
 ********************************************************************/
$page_title='Business Employee Availability';
include('./assets/header.inc');
/* Instantiate database connection object, called $db */
include('./assets/databaseClass.inc');
?>
<!--Body Start--> 
<?php
include('./assets/ownerChecker.inc');
include('./assets/businessBannerAndNav.inc');
?>
<div class='contentHereDiv'>
<h1>Employee Availability</h1>
<p> Select a date to view employee schedule, for that date. </p>
<div id='calendar'></div>
</div>
<?php
/***************************************************************************************
*    Title: FullCalendar open source code
*    Author: Adam Shaw
*    Date: 2017
*    Code version: v3.3.1
*    Availability: https://fullcalendar.io/docs/
*
***************************************************************************************/

/* Script used to initialise the fullCalendar plugin from https://fullcalendar.io/ 
 * And retrieve data from sql database
 */
?>
<script>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
		header: {
			left: 'prev,today,next',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		
		
		dayOfMonthFormat: 'ddd DD/MM',
		<?php
			$results = $db->select("SELECT openingTime, closingTime from business WHERE ABN = '{$_SESSION['abn']}'");
			while($row = mysqli_fetch_array($results)) {
				print "minTime: '{$row['openingTime']}',";
				print "maxTime: '{$row['closingTime']}',";
			}
		?>
		allDaySlot:false,	
		defaultView: 'month',
		editable: false, 
		height:'auto',
		
			
		events: [{
			title: 'Meeting',
			start: '2017-03-20T10:30:00',
			end: '2017-03-20T12:30:00'
		},
					
		<?php
			$results = $db->select("SELECT employeeName, startDateTime, endDateTime 
			FROM workperiod AS wp INNER JOIN employee AS e ON wp.employeeID=e.employeeID WHERE businessID = '{$_SESSION['abn']}';");

			while($row = mysqli_fetch_array($results)) {							
				print_r("{");
				print_r("title: '".$row['employeeName']."',");
	         print_r("start: '".$row['startDateTime']."',");
				print_r("end: '".$row['endDateTime']."'");
				print_r("},");
			}
		?>
		],
		
		dayClick: function(date, jsEvent, view) {

            console.log(view.name);
            if ( view.name === "month" ) {
               $('#calendar').fullCalendar('gotoDate', date);
               $('#calendar').fullCalendar('changeView', 'agendaDay');
            }
				if ( view.name === "agendaWeek" ) {
               $('#calendar').fullCalendar('gotoDate', date);
               $('#calendar').fullCalendar('changeView', 'agendaDay');
            }
				
				
        }})});
	</script>
<!--Body End-->
<?php
include('./assets/footer.inc');
?>
