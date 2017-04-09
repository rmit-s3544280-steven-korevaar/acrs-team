<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *				Steven Korevaar	s3544280
 *
 * PHP script used to process employee add working period.
 *
 * The script will check if all data fields are filled in, and whether
 * the date time is valid.
 * If not return back to the Add shift page with error message.
 *
 * If true it will check whether the date times are valid and insert 
 * the work period into the table and return a success message.
 * 
 ********************************************************************/
/* Php script to process new shifts */
session_start();
if (isset($_POST['date']) && !empty($_POST['startTime']) && !empty($_POST['endTime']) && !empty($_POST['employeeID']))
{

	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$employeeID = $_POST['employeeID'];
	
	/* Rearrange date time into format which PHP and MySQL can manipulate */
	$datePieces = explode("/", $date);
	$combinestartDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $startTime:00";
	$combineendDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $endTime:00";

	$startDateTime = date("Y-m-d H:i:s", strtotime($combinestartDateTime));
	$endDateTime = date("Y-m-d H:i:s", strtotime($combineendDateTime));
	
	/* Check whether the set End Date Time is after the Start Date Time */
	if($startDateTime < $endDateTime) {
		$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
		$query = "insert into workPeriod values('$startDateTime','$endDateTime','$employeeID');";
		$results = mysqli_query($connect,$query) or die(mysqli_error($connect));
		$_SESSION['shiftAdded'] = "Successfully added working time.";
		header("location: ../../businessPageEmployeeAddShift.php");
	}
	else {
		$_SESSION['shiftError'] = "The end time must be after the start time.";
		header("location: ../../businessPageEmployeeAddShift.php");
	}
	
}
else
{
	$_SESSION['shiftError'] = "Please enter in all fields.";
	header("location: ../../businessPageEmployeeAddShift.php");
} 



?>