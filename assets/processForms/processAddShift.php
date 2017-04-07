<?php
/* Php script to process new shifts */
session_start();
if (isset($_POST['date']) && !empty($_POST['startTime']) && !empty($_POST['endTime']) && !empty($_POST['employeeID']))
{

	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$employeeID = $_POST['employeeID'];
	
	$datePieces = explode("/", $date);
	$combinestartDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $startTime:00";
	$combineendDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $endTime:00";

	$startDateTime = date("Y-m-d H:i:s", strtotime($combinestartDateTime));
	$endDateTime = date("Y-m-d H:i:s", strtotime($combineendDateTime));
	
	if($startDateTime < $endDateTime) {
		$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
		$query = "insert into workPeriod values('$startDateTime','$endDateTime','$employeeID');";
		$results = mysqli_query($connect,$query) or die(mysqli_error($connect));
		
		header("location: ../../businessPageEmployeeAvailability.php");
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