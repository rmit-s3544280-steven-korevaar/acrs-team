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
?>
<!--Body Start--> 
<?php
include('./assets/customerBannerAndNav.inc');
?>
<div class='CustomerBookingCalendarDiv'>
<div id='calendar'></div>
</div>
<div class='CustomerBookingMakeABookingDiv'>
<h2>Make a booking</h2>
<ol>
<li>Select a date in the calendar and view available slots.</li>
<li>Enter in booking time below.</li>
<li>Enter in extra requests.</li>
<li>Book appointment.</li>
</ol>
<form method='post' action='./assets/processForms/processBooking.php'>
<table>
<tr><th>Date: </th></tr>
<tr><td><input type="text" name="date" id="getDateFromCalendar" readonly/></td></tr>
<tr><th>Start Time: </th></tr>
<tr><td><input type="time" name="startTime"/></td></tr>
<tr><th>End Time: </th></tr>
<tr><td><input type="time" name="endTime"/></td></tr>
<tr><th>Extra notes: </th></tr>
<tr><td><textarea name="otherDetails" placeholder="Enter any other special requests..."></textarea></td></tr>
<th><tr>Select Employee</th></tr>
<tr><td>
<select name="employeeID" id="employeeID">
<option value="any">Any Available</option>
  <?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "SEPT_Assignment_Part_1";
		//Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		//Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$query = "SELECT * FROM employee;";
		$results = mysqli_query($conn,$query);

		while($row = mysqli_fetch_array($results)) {							
			print_r("<option value= \"".$row['employeeID']."\">".$row['employeeName']."</option>");
		}
  ?>
</select>
</tr></td>
<tr><td><input type="submit" value="Book Appointment"/></td></tr>
<?php
if(isset($_SESSION['bookingError']) && !empty($_SESSION['bookingError'])){
	print("<tr><td class='errorMessage'>\n");
	print("<p> {$_SESSION['bookingError']} </p>\n");
	print("</td></tr>\n");
	unset($_SESSION['bookingError']);
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
			minTime: "09:00:00",
			maxTime: "18:00:00",
			allDaySlot:false,	
			defaultView: 'month',
			editable: false, 
			height:'auto',
			
				
			events: [
						
			<?php
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "SEPT_Assignment_Part_1";
				//Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				//Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$query = "SELECT employeeName, startDateTime, endDateTime FROM workperiod AS wp INNER JOIN employee AS e ON wp.employeeID=e.employeeID;";
				$results = mysqli_query($conn,$query);

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
					var today = new Date();
					today.setDate(today.getDate() - 1);
					
					console.log(today);

					if ( view.name === "month" && date >= today ) {
						document.getElementById('getDateFromCalendar').value = moment(date).format("DD/MM/YYYY");
						$('#calendar').fullCalendar('gotoDate', date);
						$('#calendar').fullCalendar('changeView', 'agendaDay');
					}
					
					if ( view.name === "agendaWeek" ) {
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
