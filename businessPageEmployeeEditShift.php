<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *				Steven Korevaar	s3544280
 * PHP script to generate the page for business owner to edit a
 * shift/work period for an employee.
 * Uses a plugin from FullCalendar.io.
 * 
 ********************************************************************/
$page_title='Business Employee Edit Shift';
include('./assets/header.inc');
/* Instantiate database connection object, called $db */
include('./assets/databaseClass.inc');
?>
<!--Body Start--> 
<?php
include('./assets/ownerChecker.inc');
include('./assets/businessBannerAndNav.inc');
?>
<div class='CustomerBookingCalendarDiv'>
<div id='calendar'></div>
</div>
<div class='CustomerBookingMakeABookingDiv'>
<h2>Edit a Shift</h2>
<ol>
<li>Select employee to show scheduled shifts.</li>
<span>OR</span>
<li>Select a date in the calendar.</li>
<li>Enter in new time below.</li>
<li>Edit or Delete shift.</li>
</ol>
<form method='post' action='./assets/processForms/processEditShift.php'>
<table>
<tr><th>Employee Name: </th></tr>
<tr><th>
<select name="employeeID" id="employeeNameOptions" onchange='changeSessionEmployeeID();'>
<option class='noDisplay'>Select Employee</option>
  <?php
		$results = $db->select("SELECT * FROM employee;");
		if(isset($_SESSION['employeeID']) && !empty($_SESSION['employeeID'])){
			$employeeID = $_SESSION['employeeID'];
			while($row = mysqli_fetch_array($results)) {
				if($employeeID == $row['employeeID']){
					print "<option value = {$row['employeeID']} selected>{$row['employeeName']}</option>\n";
				}
				else
				{
					print "<option value = {$row['employeeID']}>{$row['employeeName']}</option>\n";
				}
			}
		}
		else
		{
			while($row = mysqli_fetch_array($results)) {
				print "<option value = {$row['employeeID']}>{$row['employeeName']}</option>\n";
			}
		}
  ?>
</select>
</th></tr>
<tr><th>Date: </th></tr>
<tr><td><input type="text" name="date" id="getDateFromCalendar" readonly/></td></tr>
<tr><th>Start Time: </th></tr>
<tr><td><input type="time" name="startTime" id="getStartTimeFromCalendar"/></td></tr>
<tr><th>End Time: </th></tr>
<tr><td><input type="time" name="endTime" id="getEndTimeFromCalendar"/></td></tr>
<!--Hidden field to pass workperiodID to the processEditShift.php-->
<tr><td><input type="hidden" name="workperiodID" id="getWorkPeriodIDFromCalendar"></td></tr>
<!--Hidden field to pass employeeID to the processEditShift.php-->
<tr><td><input type="hidden" name="employeeID" id="getEmployeeIDFromCalendar"></td></tr>
<tr><td><input type="submit" name="action" value="Edit Shift"/></td></tr>
<tr><td><input type="submit" name="action" value="Delete Shift"/></td></tr>
<?php

if(isset($_SESSION['shiftAdded']) && !empty($_SESSION['shiftAdded'])){
	print("<tr><td class='successMessage'>\n");
	print("<p> {$_SESSION['shiftAdded']} </p>\n");
	print("</td></tr>\n");
	unset($_SESSION['shiftAdded']);
}
else if(isset($_SESSION['shiftError']) && !empty($_SESSION['shiftError'])){
	print("<tr><td class='errorMessage'>\n");
	print("<p> {$_SESSION['shiftError']} </p>\n");
	print("</td></tr>\n");
	unset($_SESSION['shiftError']);
}
?>
</table>
</form>
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

/* Script used to initialise the fullCalendar component from https://fullcalendar.io/ 
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
			$results = $db->select("SELECT openingTime, closingTime from business");
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
			/**
			 * If $_SESSION['employeeID'] is set and has a value,
			 * Print only the selected employee work schedule 
			 */
			if(isset($_SESSION['employeeID']) && !empty($_SESSION['employeeID'])){
				$employeeID = $_SESSION['employeeID'];
				$results = $db->select("SELECT wp.employeeID, workperiodID, employeeName, startDateTime, endDateTime 
				FROM workperiod AS wp INNER JOIN employee AS e ON wp.employeeID=e.employeeID 
				where wp.employeeID = '$employeeID';");

				unset($_SESSION['employeeID']);
			}
			/**
			 * If $_SESSION['employeeID'] is not set,
			 * Print all employee work schedule 
			 */
			else
			{
				$results = $db->select("SELECT wp.employeeID, workperiodID, employeeName, startDateTime, endDateTime 
				FROM workperiod AS wp INNER JOIN employee AS e ON wp.employeeID=e.employeeID;");
			}
			while($row = mysqli_fetch_array($results)) {							
				print_r("{");
				print_r("title: '".$row['employeeName']."',");
				print_r("start: '".$row['startDateTime']."',");
				print_r("end: '".$row['endDateTime']."',");
				print_r("employeeID: '".$row['employeeID']."',");
				print_r("workperiodID: '".$row['workperiodID']."'");
				print_r("},");
			}
		?>
		],
		
		dayClick: function(date, jsEvent, view) {
			console.log(view.name);
			if ( view.name === "month" ) {
				document.getElementById('getDateFromCalendar').value = moment(date).format("DD/MM/YYYY");
				$('#calendar').fullCalendar('gotoDate', date);
				$('#calendar').fullCalendar('changeView', 'agendaDay');
			}
			if ( view.name === "agendaWeek" ) {
				document.getElementById('getDateFromCalendar').value = moment(date).format("DD/MM/YYYY");
				$('#calendar').fullCalendar('gotoDate', date);
				$('#calendar').fullCalendar('changeView', 'agendaDay');
			}
				
				
		},
		eventClick: function(calEvent, jsEvent, view){
			console.log(view.name);
			//Gets the clicked events date and set value of Date.
			document.getElementById('getDateFromCalendar').value = moment(calEvent.start).format("DD/MM/YYYY");
			//Gets the clicked events start date/time and set value of Start time in the form.
			document.getElementById('getStartTimeFromCalendar').value = moment(calEvent.start).format("HH:mm");
			//Gets the clicked events end date/time and set value of End time in the form.
			document.getElementById('getEndTimeFromCalendar').value = moment(calEvent.end).format("HH:mm");
			//Gets the clicked events custom workperiodID and set value of the hidden workperiodID in the form.
			document.getElementById('getWorkPeriodIDFromCalendar').value = calEvent.workperiodID;
			//Gets the clicked events custom employeeID and set value of the hidden employeeID in the form.
			document.getElementById('getEmployeeIDFromCalendar').value = calEvent.employeeID;
		}
		})});
	</script>

<!--Body End-->
<?php
include('./assets/footer.inc');
?>
