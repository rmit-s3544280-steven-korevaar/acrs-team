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

if (!empty($_POST['selectedCustomer']) && $_POST['selectedCustomer'] != 'Select Customer' && !empty($_POST['date']) && !empty($_POST['startTime']) && !empty($_POST['endTime']) && !empty($_POST['employeeID']))
{

	$username = $_POST['selectedCustomer'];
	$ABN = $_SESSION['abn'];
	
	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$otherDetails = $_POST['otherDetails'];
	$employee = $_POST['employeeID'];
	$activities = $_POST['selectedActivities'];

	
	/* Rearrange date time into format which PHP and MySQL can manipulate */
	$startDateTime = dateFormatter($date, $startTime);
	$endDateTime = dateFormatter($date, $endTime);
	
	/* Check whether the set End Date Time is after the Start Date Time */
	if( $endDateTime > $startDateTime ){	
		
		if($employee == "any")
		{
			
			$found = findAvailableEmp($startDateTime, $endDateTime, $db);
			
			if($found == -1)
			{
				$_SESSION['bookingError'] = "There are no available employees during this time.";
				$logger->error("Booking was not successful, there are no available employees.");
				header("location: ../../businessPageCreateBooking.php");
			}
			else
			{
				$employee = $found;
			}
		}
		
		$workPeriodBool = isEmpWorking($employee, $startDateTime, $endDateTime, $db);
		$bookingBool = isEmpBooked($employee, $startDateTime, $endDateTime, $db);
	
		if($bookingBool == 1 && $workPeriodBool == 1) 
		{
			
			$results = $db->insert("insert into booking values(null,\"".$username."\",\"".$startDateTime."\",\"".$endDateTime."\",\"".$ABN."\",\"".$otherDetails."\");");
			
			$results = $db->select("select bookingID from booking where businessID = '{$_SESSION['abn']}' and username = \"".$username."\" order by bookingID desc limit 1;");
			$bookingIDinit = mysqli_fetch_array($results);
			$bookingID = $bookingIDinit["bookingID"];
			
			$results = $db->insert("insert into bookingEmployee values('$bookingID','$employee');");
			
			foreach($activities as $id => $activity)
			{
				$db->insert("INSERT into bookingactivity VALUES('$activity',".$bookingID.");");
			}
			
			$_SESSION['bookingSuccess'] = "Successfully booked";
			header("location: ../../businessPageCreateBooking.php");
		}
		else if($workPeriodBool == 1 && $bookingBool == 0) 
		{
			$_SESSION['bookingError'] = "There is a booking clash with this Employee.";
			$logger->error("Booking was not successful, There is a booking clash with this Employee.");
			header("location: ../../businessPageCreateBooking.php");
		}
		else
		{
			$_SESSION['bookingError'] = "There are no available employees for this time period.";
			$logger->error("Booking was not successful, There are no available employees for this time period.");
			header("location: ../../businessPageCreateBooking.php");
		}
	}
	else
	{
		$_SESSION['bookingError'] = "End Time must be after Start Time.";

		$logger->error("Booking was not successful, end time must be after start time ");
		header("location: ../../businessPageCreateBooking.php");
	}
}
else
{
	$_SESSION['bookingError'] = "Please enter in all fields.";

	$logger->error("Booking was not successful, all fields have to be filled");
	header("location: ../../businessPageCreateBooking.php");
} 

function findAvailableEmp($startDT, $endDT, $db)
{
	$query = "SELECT * FROM employee WHERE businessID = '{$_SESSION['abn']}';";
	$results = $db->select($query);
	$found = 0;
	$workPeriodBool = 0;
	$bookingBool = 0;
	
	while($row = mysqli_fetch_array($results)) {	
		$empID = $row['employeeID'];
		$workPeriodBool = isEmpWorking($empID, $startDT, $endDT, $db);
		if( $workPeriodBool == 1)
		{
			$bookingBool = isEmpBooked($empID, $startDT, $endDT, $db);
			if($bookingBool == 1) 
			{
				return $empID;
			}
		}
	}
	
	return -1;
}

function isEmpWorking($emp, $startDT, $endDT, $db)
{
	$results = $db->select("SELECT * FROM workperiod WHERE employeeID = '$emp';");

	$bool = 0;
	$workIterator = 0;
	
	while($row = mysqli_fetch_array($results)) {	
		
		if($row['employeeID'] == $emp)
		{
			$workIterator++;		
			$sdt = $row['startDateTime'];
			$edt = $row['endDateTime'];
			
			if($startDT >= $sdt && $endDT <= $edt)
			{
				$bool = 1;
				break;
			}
		}
	}
	
	return $bool;
}


function isEmpBooked($emp, $startDT, $endDT, $db) 
{
	//$results = $db->select("SELECT * FROM workperiod AS wp INNER JOIN employee AS e ON wp.employeeID=e.employeeID;");

	//$results = $db->select("SELECT * FROM booking WHERE employee=".$emp.";");
	
	$results = $db->select("SELECT * FROM booking AS b INNER JOIN bookingEmployee AS e ON b.bookingID=e.bookingID WHERE businessID = '{$_SESSION['abn']}' AND employeeID=".$emp.";");

	$bool = 1;
	$bookingIterator = 0;
	while($row = mysqli_fetch_array($results)) {	
		$bookingIterator++;
		$sdt = $row['startDateTime'];
		$edt = $row['endDateTime'];		
		if( ($startDT	>= $sdt && $endDT 	<= $edt) || 
			($startDT 	>= $sdt && $startDT <= $edt) ||
			($endDT 	>= $sdt && $endDT	<= $edt)
			)
		{
			$bool = 0;
			break;
		}
	}
	return $bool;
}

function dateFormatter($date, $time)
{
	$datePieces = explode("/", $date);
	$combineDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $time:00";
	return date("Y-m-d H:i:s", strtotime($combineDateTime));
}

?>