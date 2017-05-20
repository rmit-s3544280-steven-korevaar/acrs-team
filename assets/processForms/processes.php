<?php
require_once('../helpers.php');
class processes
{
	
	public static function addEmployee($employeeName, $jobTitle, $employeeID, $businessID, $db, $logger)
	{
		// Search existing employeeID, employeeID must not be existing in system.
		if( helpers::searchExistingEmployeeID($db,$employeeID) == false ){
			$result = $db->insert("insert into employee values('$employeeName','$jobTitle','$businessID','$employeeID');");
			//If successful add, send back to businessPageEmployeeAddEmployee.php with success message.
			$_SESSION['returnSuccessAddEmployeeMessage'] = "Successfully added new Employee.";
			$logger->info("Owner succes added a new employee");
			header("location: ./../../businessPageEmployeeAddEmployee.php");
		}
		else{
			/* If unsuccessfull, send back to businessPageEmployeeAddEmployee.php with error message.
			  * EmployeeID is already in system.
			  */
			$_SESSION['returnErrorAddEmployeeMessage'] = "A employee of that 'Employee Number' is already in the system.";
			$logger->error("Error occured while owner trying to add a new employee, employee number already exists");
			header("location: ./../../businessPageEmployeeAddEmployee.php");
		}
		
	}
	
	
	public static function addServices($durationM, $businessID, $serviceName, $db, $logger)
	{
		$duration = helpers::serviceDurationFormatter($durationM);
		if ( helpers::checkValidDuration($duration) == true ){
			$result = $db->insert("insert into BusinessActivity values(null, '$businessID','$serviceName','$duration');");

			if($result != false){
				//If successful add, refresh the page businessPageEmployeeEditServices.php with success message.
				$_SESSION['returnSuccess'] = "Successfully added new Service.";
				$logger->info("Owner successfully added a new service");
				header("location: ./../../businessPageEmployeeAddServices.php");
			}
		}
		else{
			$_SESSION['returnError'] = "Duration needs to be within 1 and 60 mins.";
			$logger->error("Error occured while owner trying to add a new service, Invalid duration. ");
			header("location: ./../../businessPageEmployeeAddServices.php");
		}
	}
	
	
	public static function addShift($date, $startTime, $endTime, $employeeID, $db, $logger)
	{
		/* Rearrange date time into format which PHP and MySQL can manipulate */
		$startDateTime = helpers::dateFormatter($date, $startTime);
		$endDateTime = helpers::dateFormatter($date, $endTime);
		
		/* Check whether the set End Date Time is after the Start Date Time */
		if($startDateTime < $endDateTime) {
			$result = $db->insert("insert into workPeriod values(null,'$startDateTime','$endDateTime','$employeeID');");
			if($result != false){
				$_SESSION['shiftAdded'] = "Successfully added working time.";
				$logger->info("Working time added Successfully");
				header("location: ../../businessPageEmployeeAddShift.php");
			}
			else{
				$_SESSION['shiftError'] = "Unable to add shift.";
				$logger->error("Error occured while trying to add shift");
				header("location: ../../businessPageEmployeeAddShift.php");
			}
		}
		else {
			$_SESSION['shiftError'] = "The end time must be after the start time.";
			$logger->error("Error occured while trying to add add shift, the end time must be after the start time");
			header("location: ../../businessPageEmployeeAddShift.php");
		}
		
	}
	
	
	public static function booking($username, $abn, $date, $startTime, $endTime, $employee, $otherDetails, $activities, $db, $logger, $locS, $locF)
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
					$_SESSION['bookingError'] = "There are no available employees during this time.";
					$logger->error("Booking was not successful, there are no available employees.");
					header("location: ../../customerBooking.php");
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
				

				header($locS);
			}
			else if($workPeriodBool == 1 && $bookingBool == 0) 
			{
				$_SESSION['bookingError'] = "There is a booking clash with this Employee.";
				$logger->error("Booking was not successful, There is a booking clash with this Employee.");
				header($locF);
			}
			else
			{
				$_SESSION['bookingError'] = "There are no available employees for this time period.";
				$logger->error("Booking was not successful, There are no available employees for this time period.");
				header($locF);
			}
		}
		else
		{
			$_SESSION['bookingError'] = "End Time must be after Start Time.";

			$logger->error("Booking was not successful, end time must be after start time ");
			header($locF);
		}
		
	}
	
	public static function editShift($date, $startTime, $endTime, $workPeriodID, $employeeID, $action, $db, $logger)
	{
		
		$startDateTime = helpers::dateFormatter($date, $startTime);
		$endDateTime = helpers::dateFormatter($date, $endTime);
		
		if($action == "Edit Shift"){
			if( helpers::timeCheck($startDateTime,$endDateTime) == true ){
				if( helpers::checkOverlap($startDateTime, $endDateTime, $employeeID, $workPeriodID, $db) == true )
				{
					$result = $db->update("UPDATE workPeriod SET startDateTime='$startDateTime', 
					endDateTime='$endDateTime' WHERE workperiodID=$workPeriodID;");
					$_SESSION['shiftAdded'] = "Successfully Edited working time.";
					$logger->info("Working time has been changed successfully");
					header("location: ../../businessPageEmployeeEditShift.php");
				}
				else{
					$_SESSION['shiftError'] = "Work Period cannot overlap.";
					$logger->error("Error occured while changing the shift, work period cannot overlap");
					header("location: ../../businessPageEmployeeEditShift.php");
				}
			}
			else{
				$_SESSION['shiftError'] = "The end time must be after the start time.";
				$logger->error("Error occured while changing the shift, the end time must be after the start time");
				header("location: ../../businessPageEmployeeEditShift.php");
			}
		}
		elseif($action == "Delete Shift"){
			$result = $db->delete("DELETE FROM workPeriod WHERE workperiodID=$workPeriodID;");
			$_SESSION['shiftAdded'] = "Successfully Deleted working time.";
			$logger->info("Working time has been deleted successfully");
			header("location: ../../businessPageEmployeeEditShift.php");
		}
	}
	
	public static function login($username, $password, $db, $logger)
	{
		//Check if valid user.
		$results = $db->select("select * from user where username='$username' and password=SHA('$password');");
		if(mysqli_num_rows($results) > 0){
			//Store username in the global array under the username variable, for future use.
			$_SESSION['username'] = "$username";
			//Check to see if it is a customer or a owner
			$checkResult = $db->select("select * from userbusiness where username like '$username' AND ABN = '{$_SESSION['abn']}';");
			if(mysqli_num_rows($checkResult) > 0){	//If a result is found, check to see if the user is a owner.
				$logger->info("Owner logged in");
				header("location: ../../businessPage.php");	//If is a owner, send to owner management page
			}
			
			else{	//If nothing is found in the userbusiness table, the user is not a owner, but is just a regular customer
				$logger->info("Customer logged in");
				header("location: ../../customerPage.php");	//If is a customer, send to customer page
			}
		}
		else{
			//If incorrect username or password, send back to index.php with a error message.
			$_SESSION['loginError'] = "! Incorrect username or password, Please try again.";
			$logger->info("User entered invalid login information.");
			header("location: ../../login.php");
		}
				
	}
	
	public static function newBusiness($password, $checkpassword, $openingTime, $closingTime, $name, $ownerName, $address, $phoneNo, $ABN, $username, $db, $logger)
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

				$_SESSION['registerSuccess'] = "Business successfully registered.";
				$logger->info("Business successfully registered");
				header("location: ../../createANewBusiness.php");
			}
			else{
				$_SESSION['returnData'] = array($_POST['name'],$_POST['ownerName'],$_POST['address'],$_POST['phoneNo'],
				$_POST['openingTime'],$_POST['closingTime'],$_POST['ABN'],$_POST['username']);
				$_SESSION['registerError'] = "! Closing time must be after the Opening time.";
				$logger->error("Error occured while user was trying to register, Invalid closing/opening time.");
				header("location: ../../createANewBusiness.php");
			}
		}
		else{
			$_SESSION['returnData'] = array($_POST['name'],$_POST['ownerName'],$_POST['address'],$_POST['phoneNo'],
			$_POST['openingTime'],$_POST['closingTime'],$_POST['ABN'],$_POST['username']);
			$_SESSION['registerError'] = "! Passwords must match.";
			$logger->error("Error occured while user was trying to register, Passwords do not match.");
			header("location: ../../createANewBusiness.php");
			
		}
		
	}
	
	public static function register($username, $fullname, $address, $phone, $password, $db, $logger)
	{
		$result = $db->insert("insert into user values('$username','$fullname','$address','$phone',SHA('$password'));");
		if($result != false){
			//If successful register, send back to index.php with success message.
			$_SESSION['registerSuccess'] = "Register successful, Please login.";
			$logger->info("User successfully registered");
			header("location: ../../login.php");
		}
		else{//If username already exists, send back to index.php with a error message.
			$_SESSION['registerError'] = "! That username is unavailable, Please try another.";
			$logger->error("Error occured while user was trying to register, username is unavailable");
			header("location: ../../login.php");
		}
	}
	
}

?>