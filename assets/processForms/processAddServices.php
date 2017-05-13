<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *				Asli Yoruk			s3503519
 *
 * PHP script used to process add new employee into the system.
 *
 * The script will check if all data fields are filled in.
 * If not return back to the Add new employee with error message.
 *
 * If true it will add the new employee into the database.
 * The query will return a message if the employeeID is not unique,
 * and return a error message.
 * 
 ********************************************************************/

/* Adding logging config path */
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");

/* Instantiate database */
include('./databaseClass.inc');

/* EDIT SERVICES PART */

$query = "SELECT * FROM BusinessActivity; ";
$results = $db->select($query);
	while($row = mysqli_fetch_array($results)) {
		var_dump($row);
	}


/* $activity = $db->select("select activityID, activityName, duration from businessActivity;");
while ($row = mysqli_fetch_array($activity)) {
		echo "<tr><td colspan='2'><label for=".$row['activityName']." >".$row['activityName']."</label>";
		echo "<input type='checkbox' id='activity' name=selectedActivities[] value=".$row['activityID']." duration=".$row['duration']." class='inlinelabel' onclick='updateEndTime()' /></td></tr>";
			}
*/




/* ADD SERVICES PART */

/*Check if input data exists and Initialise variables to call easier*/
$checkForData = array('businessID','serviceName','duration');
$checkFlag = true;
foreach($checkForData as $data){
	if(empty($_POST[$data])){
		$checkFlag = false;
	}
}

/*If all data exists, continue with the adding employee process*/
if($checkFlag == true){
	$businessID = $_POST['businessID'];
	$serviceName = $_POST['serviceName'];
	$duration = $_POST['duration'];
	
	$result = $db->insert("insert into BusinessActivity values(null, '$businessID','$serviceName','$duration');");

	if($result != false){
		//If successful add, refresh the page businessPageEmployeeEditServices.php with success message.
		$_SESSION['returnSuccessAddServiceMessage'] = "Successfully added new Service.";
		$logger->info("Owner succes added a new service");
		header("location: ./../../businessPageEmployeeEditServices.php");
	}

	else{
		    /* If unsuccessfull, show the error msg 
			  */
			$_SESSION['returnErrorAddServiceMessage1'] = "blabla";
			$logger->error("Error occured while owner trying to add a new service");
			header("location: ./../../businessPageEmployeeEditServices.php");
		}
}

else{
	$_SESSION['returnErrorAddServiceMessage2'] = "Please enter data in all fields.";
	$logger->error("Error occured while owner trying to add a new service, all fields need to be filled ");
	header("location: ./../../businessPageEmployeeEditServices.php");
}

	exit(0);
?>