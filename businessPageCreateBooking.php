<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 * 			Christine Huynh	s3438653
 * PHP script to generate the page for customer booking.
 * Uses a plugin from FullCalendar.io.
 * 
 ********************************************************************/
	$page_title='Customer New Booking';
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
<h2>Make a booking</h2>
<ol>
	<li>Select Customer.</li>
	<li>Select a date in the calendar and view available slots.</li>
	<li>Enter in booking start time.</li>
	<li>Select services.</li>
	<li>Enter in extra requests.</li>
	<li>Book appointment.</li>
</ol>
<form method='post' id='bookingform' action='./assets/processForms/processBusinessBooking.php'>
<table>
		<tr><th colspan="2">Customer Name: </th></tr>
		<tr><th><select name="selectedCustomer" id="customerNameOptions" >
		<option class='noDisplay'>Select Customer</option>
		<?php
			$query="select * from user where username <> (select username from userbusiness) order by fullname asc;";
			$results = $db->select($query);
			while($row = mysqli_fetch_array($results)) {							
				print "<option value= {$row['username']}>{$row['fullname']}</option>";
			}
		?>
		</select></tr></th>
		<tr><th colspan="2">Date: </th></tr>
		<tr><td colspan="2"><input type="text" name="date" id="getDateFromCalendar"/></td></tr>
		<tr><th>Start Time: </th><th>End Time:</th></tr>
		<tr><td><input type="time" id="startTime" name="startTime" onchange="getStartTime()" required/></td>
		<td><input type="time" id="endTime" name="endTime" readonly/></td></tr> <!--CH: 18/04-->
		<tr><th colspan="2">Services: </th></tr> <!--CH: 18/04-->

		<?php
			$activity = $db->select("select activityID, activityName, duration from businessActivity;");
			while ($row = mysqli_fetch_array($activity)) {
				echo "<tr><td colspan='2'><label for=".$row['activityName']." >".$row['activityName']."</label>";
				echo "<input type='checkbox' id='activity' name=selectedActivities[] value=".$row['activityID']." duration=".$row['duration']." class='inlinelabel' onclick='updateEndTime()' /></td></tr>";
			}
		?>
		<tr><th colspan="2">Employee: (optional)</th></tr>
		<tr><td colspan="2"><select name="employeeID" id="employeeID">
		<option value="any">Any Available</option>
		<?php
			$results = $db->select("SELECT * FROM employee;");
				while($row = mysqli_fetch_array($results)) {							
					print_r("<option value= \"".$row['employeeID']."\">".$row['employeeName']."</option>");
				}
		?>
		</select></td></tr>

		</td></tr> <!--Ch: 18/04-->
		<tr><th colspan="2">Extra notes: </th></tr>
		<tr><td colspan="2"><textarea name="otherDetails" placeholder="Enter any other special requests..."></textarea></td></tr>
		<tr><td colspan="2"><input type="submit" value="Book Appointment"/></td></tr>


			<?php
			if(isset($_SESSION['bookingError']) && !empty($_SESSION['bookingError'])){
				print("<tr><td class='errorMessage'>\n");
				print("<p> {$_SESSION['bookingError']} </p>\n");
				print("</td></tr>\n");
				unset($_SESSION['bookingError']);
			}
			elseif(isset($_SESSION['bookingSuccess']) && !empty($_SESSION['bookingSuccess'])){
				print("<tr><td class='successMessage'>\n");
				print("<p> {$_SESSION['bookingSuccess']} </p>\n");
				print("</td></tr>\n");
				unset($_SESSION['bookingSuccess']);
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
			left: 'today,next',
			center: 'title',
			right: 'month,agendaDay'
		},
		
		
		dayOfMonthFormat: 'ddd DD/MM',
		minTime: "09:00:00",
      maxTime: "18:00:00",
		allDaySlot:false,	
		defaultView: 'month',
		editable: false, 
		height:'auto',
		
			
		events: [{
			title: 'Test',
			start: '2017-03-20T10:30:00',
			end: '2017-03-20T12:30:00'
		},
					
		<?php
			$query = "SELECT * FROM booking AS b LEFT JOIN (SELECT bookingID, employeeName FROM bookingemployee be, employee e WHERE be.employeeID=e.employeeID) as be ON b.bookingID=be.bookingID;";
			$results = $db->select($query);
			while($row = mysqli_fetch_array($results)) {							
				print_r("{");
				if($row['employeeName'] != NULL)
				{
					print_r("title: 'Booking time filled for: {$row['employeeName']}',");
				}
				else{
					print_r("title: 'Booking time filled.',");
				}
				print_r("start: '".$row['startDateTime']."',");
				print_r("end: '".$row['endDateTime']."',");
				print_r("color: 'red'");
				print_r("},");
			}
			
			$query = "SELECT employeeName, startDateTime, endDateTime FROM workperiod AS wp INNER JOIN employee AS e ON wp.employeeID=e.employeeID;";
			$results = $db->select($query);

			while($row = mysqli_fetch_array($results)) {							
				print_r("{");
				print_r("title: '".$row['employeeName']."',");
				print_r("start: '".$row['startDateTime']."',");
				print_r("end: '".$row['endDateTime']."'");
				print_r("},");
			}
			
		?>
		],
		//Hide all events in month view
		eventRender: function(event, element, view) {
		if(view.type == 'month') {
			$(element).css("display", "none");
		}},
		//On Click event set date field to the selected date.
		dayClick: function(date, jsEvent, view) {
			var today = new Date();
			today.setDate(today.getDate() - 1);

			console.log(view.name);
			if ( view.name === "month" && date >= today ) {
				document.getElementById('getDateFromCalendar').value = moment(date).format("DD/MM/YYYY");
				$('#calendar').fullCalendar('gotoDate', date);
				$('#calendar').fullCalendar('changeView', 'agendaDay');
			}
		}
		})});
	</script>

<!--Body End-->
<?php
include('./assets/footer.inc');
?>
