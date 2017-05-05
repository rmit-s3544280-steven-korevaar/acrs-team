<?php
/* *******************************************************************

 * PHP script to generate the page for customer booking.
 * Uses a plugin from FullCalendar.io.
 * 
 ********************************************************************/
	$page_title='Add Services';
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
<h1>Add new service to the system</h1>
<form method='post' action='./assets/processForms/processAddEmployee.php'>
<table class="centreTable">
<tr>
<th>Service name: </th>
<td><input type="text" name="employeeName"/></td>
</tr>
<tr>
<tr><th colspan="2">Responsible Employee: </th></tr>
		<tr><td colspan="2"><select name="employeeID" id="employeeID">
		<option value="any">Please Select</option>
		<?php
			$results = $db->select("SELECT * FROM employee;");
				while($row = mysqli_fetch_array($results)) {							
					print_r("<option value= \"".$row['employeeID']."\">".$row['employeeName']."</option>");
				}
		?>
		</select></td></tr>
<tr>

<tr><th colspan="2">Responsible Employee: (Optinal) </th></tr>
		<tr><td colspan="2"><select name="employeeID" id="employeeID">
		<option value="any">Please Select</option>
		<?php
			$results = $db->select("SELECT * FROM employee;");
				while($row = mysqli_fetch_array($results)) {							
					print_r("<option value= \"".$row['employeeID']."\">".$row['employeeName']."</option>");
				}
		?>
		</select></td></tr>
<tr>
	<th>Start Time: </th><th>End Time:</th>
</tr>


<!-- Or we can do "multiple selected" dropdown box or something-->


		<tr><td><input type="time" id="startTime" name="startTime" onchange="getStartTime()" required/></td>
		<td><input type="time" id="endTime" name="endTime" readonly/></td></tr> 
</table>
<table class="centreTable">
<tr><td><input type="submit" value="Add Service"/></td></tr>
</table>




<!-- I want to show all the existing services and put a edit and delete options next to it,
	and a quick text line at the end to quick add services 

	OR

	another page for adding services
	-->

<!--Body End-->
<?php
include('./assets/footer.inc');
?>
