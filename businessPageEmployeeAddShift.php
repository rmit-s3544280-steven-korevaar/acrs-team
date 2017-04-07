<?php
$page_title='Business Employee Add Shift';
include('./assets/header.inc');
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
<h2>Set a Shift</h2>
<ol>
<li>Select a date in the calendar</li>
<li>Enter in shift time below.</li>
<li>Set shift.</li>
</ol>
<form method='post' action='./assets/processForms/processAddShift.php'>
<table>
<tr><th>Employee Name: </th></tr>
<tr><th>
<select name="employeeID" id="employeeID">
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
</th></tr>
<tr><th>Date: </th></tr>
<tr><td><input type="text" name="date" id="getDateFromCalendar" readonly/></td></tr>
<tr><th>Start Time: </th></tr>
<tr><td><input type="time" name="startTime"/></td></tr>
<tr><th>End Time: </th></tr>
<tr><td><input type="time" name="endTime"/></td></tr>
<tr><td><input type="submit" value="Set Shift"/></td></tr>
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
		minTime: "09:00:00",
      maxTime: "18:00:00",
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
				
				
        }})});
	</script>

<!--Body End-->
<?php
include('./assets/footer.inc');
?>
