<?php
/* Php script to process new Bookings */
session_start();
if (isset($_POST['date']) && !empty($_POST['startTime']) && !empty($_POST['endTime']))
{
	$username = $_SESSION['username'];
	$ABN = $_SESSION['abn'];
	
	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$otherDetails = $_POST['otherDetails'];
	
	$datePieces = explode("/", $date);
	$combinestartDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $startTime:00";
	$combineendDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $endTime:00";

	$startDateTime = date("Y-m-d H:i:s", strtotime($combinestartDateTime));
	$endDateTime = date("Y-m-d H:i:s", strtotime($combineendDateTime));
	
	$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
	$query = "insert into booking values(null,'$username','$startDateTime','$endDateTime','$ABN','$otherDetails');";
	$results = mysqli_query($connect,$query) or die(mysqli_error($connect));
	
	header("location: ../../customerPage.php");
}
else
{
	$_SESSION['bookingError'] = "Please enter in all fields.";
	header("location: ../../customerBooking.php");
} 



?>