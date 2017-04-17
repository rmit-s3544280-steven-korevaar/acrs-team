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
	$employee = $_POST['employeeID'];
	echo $employee.'</br>';
	
	/* Rearrange date time into format which PHP and MySQL can manipulate */
	$datePieces = explode("/", $date);
	$combinestartDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $startTime:00";
	$combineendDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $endTime:00";

	$startDateTime = date("Y-m-d H:i:s", strtotime($combinestartDateTime));
	$endDateTime = date("Y-m-d H:i:s", strtotime($combineendDateTime));
	
	/* Check whether the set End Date Time is after the Start Date Time */
	if( $endDateTime > $startDateTime ){	
		$conn = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($conn));
	
		$query = "SELECT * FROM workperiod WHERE employeeID = ".$employee.";";
		$results = mysqli_query($conn,$query);
		
		
		$workPeriodBool = 0;
		$workIterator = 0;
		
		while($row = mysqli_fetch_array($results)) {	
			
			if($row['employeeID'] == $employee)
			{
				$workIterator++;		
				$sdt = $row['startDateTime'];
				$edt = $row['endDateTime'];
				
				if($startDateTime >= $sdt && $endDateTime <= $edt)
				{
					$workPeriodBool = 1;
					break;
				}
			}
			
		}
	
		$query = "SELECT * FROM booking WHERE employee='.$employee.';";
		$results = mysqli_query($conn,$query);

		$bookingBool = 1;
		$bookingIterator = 0;
		while($row = mysqli_fetch_array($results)) {	
			$bookingIterator++;
			$sdt = $row['startDateTime'];
			$edt = $row['endDateTime'];		
			if( ($startDateTime 	>= $sdt && $endDateTime 	<= $edt) || 
				($startDateTime 	>= $sdt && $startDateTime <= $edt) ||
				($endDateTime 	>= $sdt && $endDateTime	<= $edt)
				)
			{
				$bookingBool = 0;
				break;
			}
		}
	
		if($bookingBool == 1 && $workPeriodBool == 1) 
		{
			$query = "insert into booking values(null,'$username','$employee','$startDateTime','$endDateTime','$ABN','$otherDetails');";
			$results = mysqli_query($conn,$query) or die(mysqli_error($conn));
			header("location: ../../customerPage.php");
		}
		else if($workPeriodBool == 1 && $bookingBool == 0) 
		{
			$_SESSION['bookingError'] = "There is a booking clash with this Employee.";
			header("location: ../../customerBooking.php");
		}
		else
		{
			$_SESSION['bookingError'] = "There are no available employees for this time period.";
			header("location: ../../customerBooking.php");
		}
		
	}
	else
	{
		$_SESSION['bookingError'] = "End Time must be after Start Time.";
		header("location: ../../customerBooking.php");
	}
}
else
{
	$_SESSION['bookingError'] = "Please enter in all fields.";
	header("location: ../../customerBooking.php");
} 



?>