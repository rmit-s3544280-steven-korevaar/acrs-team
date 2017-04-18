<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script used to process customer booking.
 *
 * The script will check if all data fields are filled in.
 * If not return back to the booking page with error message.
 *
 * If true it will check whether the date times are valid and insert 
 * booking into table.
 * 
 ********************************************************************/


//adding datalogging config 
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");


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
	
	/* Rearrange date time into format which PHP and MySQL can manipulate */
	$datePieces = explode("/", $date);
	$combinestartDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $startTime:00";
	$combineendDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $endTime:00";

	$startDateTime = date("Y-m-d H:i:s", strtotime($combinestartDateTime));
	$endDateTime = date("Y-m-d H:i:s", strtotime($combineendDateTime));
	
	/* Check whether the set End Date Time is after the Start Date Time */
	if( $endDateTime > $startDateTime ){	
	$logger->info("Booking has been made");
	$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
	$query = "insert into booking values(null,'$username','$startDateTime','$endDateTime','$ABN','$otherDetails');";
	$results = mysqli_query($connect,$query) or die(mysqli_error($connect));
	header("location: ../../customerPage.php");
	}
	else
	{
		$logger->error("Time slot entered wrong while booking");
		$_SESSION['bookingError'] = "End Time must be after Start Time.";
		header("location: ../../customerBooking.php");
	}
}
else
{
	$logger->error("Not all of the fields are entered for booking");
	$_SESSION['bookingError'] = "Please enter in all fields.";
	header("location: ../../customerBooking.php");
} 



?>