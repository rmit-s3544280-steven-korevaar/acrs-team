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
	
	public static function serviceDurationFormatter($durationM)
	{
		$durationM = intval($durationM, 10);
		$hours = (int)($durationM / 60);
		$minutes = (int)($durationM % 60);
		$duration = date("H:i:s",strtotime("0$hours:$minutes:00"));
		return $duration;
	}

	// Check Valid time
	public static function timeCheck($start, $end)
	{
		if($end < $start){
			return false;
		}
		return true;
	}
	
	public static function checkValidDuration($time)
	{
		if( $time >= date("H:i:s",strtotime("00:01:00")) && $time <= date("H:i:s",strtotime("01:00:00")) ){
			return true;
		}
		return false;
	}
	
	public static function searchExistingEmployeeID($db,$employeeID)
	{
		$result = $db->select("SELECT * FROM employee where employeeID = '$employeeID' and businessID = '{$_SESSION['abn']}';");
		if( mysqli_fetch_array($result) == null ){
			return false;
		}
		return true;
	}
	
	public static function searchExistingEmployeeIDset($db,$employeeID, $abn)
	{
		$result = $db->select("SELECT * FROM employee where employeeID = '$employeeID' and businessID = '$abn';");
		if( mysqli_fetch_array($result) == null ){
			return false;
		}
		return true;
	}
	
	public static function isEmpWorking($emp, $startDT, $endDT, $db)
	{
		$results = $db->select("SELECT * FROM workperiod WHERE employeeID = '$emp';");

		$bool = 0;
		$workIterator = 0;
		
		if($results == false)
		{
			return 0;
		}
		
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

	public static function isEmpBooked($emp, $startDT, $endDT, $db) 
	{
		$results = $db->select("SELECT * FROM booking AS b INNER JOIN bookingEmployee AS e ON b.bookingID=e.bookingID WHERE employeeID='$emp' AND businessID = '{$_SESSION['abn']}';");

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
	
	public static function isEmpBookedset($emp, $startDT, $endDT, $db, $abn) 
	{
		$results = $db->select("SELECT * FROM booking AS b INNER JOIN bookingEmployee AS e ON b.bookingID=e.bookingID WHERE employeeID='$emp' AND businessID = '$abn';");

		$bool = 1;
		$bookingIterator = 0;
		
		if($results == false)
		{
			return 0;
		}
		
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
	
	
	public static function findAvailableEmp($startDT, $endDT, $db)
	{
		$query = "SELECT * FROM employee WHERE businessID = '{$_SESSION['abn']}';";
		$results = $db->select($query);
		$found = 0;
		$workPeriodBool = 0;
		$bookingBool = 0;
		
		while($row = mysqli_fetch_array($results)) {	
			$empID = $row['employeeID'];
			$workPeriodBool = helpers::isEmpWorking($empID, $startDT, $endDT, $db);
			if( $workPeriodBool == 1)
			{
				$bookingBool = helpers::isEmpBooked($empID, $startDT, $endDT, $db);
				if($bookingBool == 1) 
				{
					return $empID;
				}
			}
		}
		
		return -1;
	}
	public static function findAvailableEmpset($startDT, $endDT, $db, $abn)
	{
		$query = "SELECT * FROM employee WHERE businessID = '$abn';";
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
	
	public static function checkOverlap($startDateTime, $endDateTime, $employeeID, $workperiodID, $db)
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
	
	public static function checkPassword($password, $checkpassword)
	{
		if($password === $checkpassword){
			return true;
		}
		return false;
	}
	
	public static function validTime($value)
	{
        if (preg_match('/^([0-1][0-9])|(2[0-3]):[0-5][0-9]$/', $value))
		{
            return 1;
        }
		else if(preg_match('/^([0-1][0-9])|(2[0-3]):[0-5][0-9]:[0-5][0-9]$/', $value))
		{
			return 1;
		}
        else
		{
            return 0;
        }
    }
	public static function insideBusinessHours($startDateTime,$endDateTime,$abn,$db)
	{
		$open;
		$close;
		$results = $db->select("select openingTime, closingTime from business where abn = '$abn';");
		while($row = mysqli_fetch_array($results)){
		$open = $row['openingTime'];
		$close = $row['closingTime'];	
		}

		if( (date("H:i:s",strtotime($startDateTime)) >= date("H:i:s",strtotime($open))) && 
		(date("H:i:s",strtotime($startDateTime)) <= date("H:i:s",strtotime($close))) &&
		(date("H:i:s",strtotime($endDateTime)) >= date("H:i:s",strtotime($open))) && 
		(date("H:i:s",strtotime($endDateTime)) <= date("H:i:s",strtotime($close)))){
			return 1;
		}
		else{
			return 0;
		}
	}
}

?>