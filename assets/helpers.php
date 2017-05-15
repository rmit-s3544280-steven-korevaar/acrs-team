<?php
require_once('./databaseClass.inc');
class helpers 
{
	// Rearrange date time into format php and mysql can manipulate.
	public static function dateFormatter($date, $time)
	{
		$datePieces = explode("/", $date);
		$combineDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $time:00";
		return date("Y-m-d H:i:s", strtotime($combineDateTime));
	}

	// Check Valid time
	public static function timeCheck($start, $end)
	{
		if($end < $start){
			return false;
		}
		return true;
	}
	
	
	
	
	public static function searchExistingEmployeeID($db, $employeeID){
		$result = $db->select("SELECT * FROM employee where employeeID = '$employeeID';");
		if( mysqli_fetch_array($result) == null ){
			return false;
		}
		return true;
	}
	
	function isEmpWorking($emp, $startDT, $endDT, $db)
	{
		$results = $db->select("SELECT * FROM workperiod WHERE employeeID = ".$emp.";");

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
		$results = $db->select("SELECT * FROM booking AS b INNER JOIN bookingEmployee AS e ON b.bookingID=e.bookingID WHERE employeeID=".$emp.";");

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
	
	function findAvailableEmp($startDT, $endDT, $db)
	{
		$query = "SELECT * FROM employee;";
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
	
	function checkOverlap($startDateTime, $endDateTime, $employeeID, $workperiodID, $db)
	{
		$check = $db->select("
			select * 
			from workperiod 
			where date('$startDateTime') = date(startDateTime) 
			and employeeID = '$employeeID' 
			and workperiodID <> '$workperiodID'
			and startDateTime <= '$endDateTime'
			and endDateTime >= '$startDateTime';
			");
		if(mysqli_num_rows($check) == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	} 
	
}

?>