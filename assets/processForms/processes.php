<?php
require_once('../helpers.php');
class processes
{
	
	public static function addEmployee($employeeName, $jobTitle, $employeeID, $businessID, $db)
	{
		// Search existing employeeID, employeeID must not be existing in system.
		if( helpers::searchExistingEmployeeID($db,$employeeID) == false ){
			$result = $db->insert("insert into employee values('$employeeName','$jobTitle','$businessID','$employeeID');");
			// added successfully
			return 1;
		}
		else{
			// no existing employee
			return 0;
		}
		
	}
	
	
	public static function addShift($date, $startTime, $endTime, $employeeID, $db)
	{
		/* Rearrange date time into format which PHP and MySQL can manipulate */
		$startDateTime = helpers::dateFormatter($date, $startTime);
		$endDateTime = helpers::dateFormatter($date, $endTime);
		
		/* Check whether the set End Date Time is after the Start Date Time */
		if($startDateTime < $endDateTime) {
			$result = $db->insert("insert into workPeriod values(null,'$startDateTime','$endDateTime','$employeeID');");
			if($result != false){
				// inserted correctly
				return 1;
			}
			else{
				// failed to insert
				return -1;
			}
		}
		else {
			// end time is before start time
			return -2;
		}
		
	}


	public static function addServices($durationM, $businessID, $serviceName, $db)
	{
		$duration = helpers::serviceDurationFormatter($durationM);
		if ( helpers::checkValidDuration($duration) == true ){
			$result = $db->insert("insert into BusinessActivity values(null, '$businessID','$serviceName','$duration');");

			if($result != false){
				// inserted correctly
				return 1;
			}
		}
		else{
			// the service duration is outside of bounds
			// must be between 0-60 minutes
			return -1;
		}
	}
	
	
	public static function booking($username, $abn, $date, $startTime, $endTime, $employee, $otherDetails, $activities, $db)
	{
		$startDateTime = helpers::dateFormatter($date, $startTime);
		$endDateTime = helpers::dateFormatter($date, $endTime);
		
		/* Check whether the set End Date Time is after the Start Date Time */
		if( helpers::timeCheck($startDateTime,$endDateTime) == true ){	
			
			if($employee == "any")
			{
				$query = "SELECT * FROM employee WHERE businessID = '{$_SESSION['abn']}';";
				$results = $db->select($query);
				$found = 0;
				$workPeriodBool = 0;
				$bookingBool = 0;
				
				while($row = mysqli_fetch_array($results)) {	
					$empID = $row['employeeID'];
					$workPeriodBool = helpers::isEmpWorking($empID, $startDateTime, $endDateTime, $db);
					if( $workPeriodBool == 1)
					{
						$bookingBool = helpers::isEmpBooked($empID, $startDateTime, $endDateTime, $db);
						if($bookingBool == 1) 
						{
							$employee = $empID;
							$found = 1;
							break;
						}
					}
				}
				
				if($found == 0)
				{
					// no employee available
					return -2;
				}
			}
			
			$workPeriodBool = helpers::isEmpWorking($employee, $startDateTime, $endDateTime, $db);
			$bookingBool = helpers::isEmpBooked($employee, $startDateTime, $endDateTime, $db);
		
			if($bookingBool == 1 && $workPeriodBool == 1) 
			{
				
				$results = $db->insert("insert into booking values(null,\"".$username."\",\"".$startDateTime."\",\"".$endDateTime."\",\"".$abn."\",\"".$otherDetails."\");");
				
				$results = $db->select("select bookingID from booking where businessID = '{$_SESSION['abn']}' and username = \"".$username."\" order by bookingID desc limit 1;");
				$bookingIDinit = mysqli_fetch_array($results);
				$bookingID = $bookingIDinit["bookingID"];
				
				$results = $db->insert("insert into bookingEmployee values('$bookingID','$employee');");
				
				foreach($activities as $id => $activity)
				{
					$db->insert("INSERT into bookingactivity VALUES('$activity',".$bookingID.");");
				}
				
				// successfully made a booking
				return 1;
			}
			else if($workPeriodBool == 1 && $bookingBool == 0) 
			{
				// employee is already booked
				return -1;
			}
			else
			{
				// no employee available
				return -2;				
			}
		}
		else
		{	
			// end time is before start time
			return -3;
		}
		
	}
	
	public static function editShift($date, $startTime, $endTime, $workPeriodID, $employeeID, $action, $db)
	{
		
		$startDateTime = helpers::dateFormatter($date, $startTime);
		$endDateTime = helpers::dateFormatter($date, $endTime);
		
		if($action == "Edit Shift"){
			if( helpers::timeCheck($startDateTime,$endDateTime) == true ){
				if( helpers::checkOverlap($startDateTime, $endDateTime, $employeeID, $workPeriodID, $db) == true )
				{
					$result = $db->update("UPDATE workPeriod SET startDateTime='$startDateTime', 
					endDateTime='$endDateTime' WHERE workperiodID=$workPeriodID;");
					// updated database successfully
					return 1;
				}
				else{
					// there is already a booking made for that time
					return -1;
				}
			}
			else{
				// end time is before start time
				return -2;
			}
		}
		elseif($action == "Delete Shift"){
			$result = $db->delete("DELETE FROM workPeriod WHERE workperiodID=$workPeriodID;");
			// deleted shift correctly
			return 2;
		}
	}
	
	public static function login($username, $password, $db)
	{
		//Check if valid user.
		$results = $db->select("select * from user where username='$username' and password=SHA('$password');");
		if(mysqli_num_rows($results) > 0){
			//Store username in the global array under the username variable, for future use.
			$_SESSION['username'] = "$username";
			//Check to see if it is a customer or a owner
			$checkResult = $db->select("select * from userbusiness where username like '$username' AND ABN = '{$_SESSION['abn']}';");
			if(mysqli_num_rows($checkResult) > 0){	//If a result is found, check to see if the user is a owner.
				// owner is logged in
				return 1;
			}
			
			else{	//If nothing is found in the userbusiness table, the user is not a owner, but is just a regular customer
				// customer is logged in
				return 2;
			}
		}
		else{
			//If incorrect username or password, send back to index.php with a error message.
			return -1;
		}
				
	}
	
	public static function newBusiness($password, $checkpassword, $openingTime, $closingTime, $name, $ownerName, $address, $phoneNo, $ABN, $username, $db)
	{
		if(helpers::checkPassword($password,$checkpassword) == true){

			if(helpers::timeCheck($openingTime,$closingTime) ){
				
				$filename = $_FILES['image']['name'];
				$location = $_FILES['image']['tmp_name'];
				
				//Move file into businessImage folder.
				move_uploaded_file($location, "./../images/businessImage/$filename");
				
				//Insert into Database
				$db->insert("INSERT INTO business VALUES('$name','$ownerName','$address','$phoneNo','$openingTime','$closingTime','$ABN','$filename');");
				
				//Insert Business Admin account
				$db->insert("INSERT INTO user VALUES('$username','$ownerName','$address','$phoneNo',SHA('$password'));");
				
				//Insert into UserBusiness middle table
				$db->insert("INSERT INTO userbusiness VALUES('$username','$ABN');");

				// successful creation of business
				return 1;
			}
			else{
				// closing time is before opening time
				return -1;
			}
		}
		else{
			// passwords do not match
			return -2;
		}
		
	}
	
	public static function register($username, $fullname, $address, $phone, $password, $db)
	{
		$result = $db->insert("insert into user values('$username','$fullname','$address','$phone',SHA('$password'));");
		if($result != false){
			//If successful register, send back to index.php with success message.
			return 1;
		}
		else{//If username already exists, send back to index.php with a error message.
			return -1;
		}
	}
	
}

?>