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

/* Adding logging config path */
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");


/* Instantiate database */
include('./databaseClass.inc');

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
		$result = $db->insert("insert into booking values(null,'$username','$startDateTime','$endDateTime','$ABN','$otherDetails');");
		if($result != false)
		{
			$logger->info("Booking was successful");
			header("location: ../../customerPage.php");
		}
		else{
			$logger->error("Booking was not successful");
			header("location: ../../customerBooking.php");
		}
	}
	else
	{
		$_SESSION['bookingError'] = "End Time must be after Start Time.";

			$logger->error("Booking was successful, end time must be after start time ");
		header("location: ../../customerBooking.php");
	}
}
else
{
	$_SESSION['bookingError'] = "Please enter in all fields.";

	$logger->error("Booking was not successful, all fields have to be filled");
	header("location: ../../customerBooking.php");
} 



?>