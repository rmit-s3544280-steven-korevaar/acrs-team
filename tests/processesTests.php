<?php

require_once("../processForms/processes.php");
//require_once("databaseMock.php");

class processesTest extends PHPUnit_Framework_TestCase 
{
	
	protected function setUp() {}

	protected function tearDown() {}

	// addEmployee($employeeName, $jobTitle, $employeeID, $businessID, $db)
	public function testAddEmployee()
	{
		include("databaseClass.inc");

		// Test Valid Entry
		$this->assertEquals(
			1,
			processes::addEmployee('John', 'Job 2', '102', '56497978719', $db)
		);

		// Test Taken ID
		$this->assertEquals(
			0,
			processes::addEmployee('John', 'Job 2', '001', '56497978719', $db)
		);

		// Test Invalid ID
		$this->assertEquals(
			0,
			processes::addEmployee('John', 'Job 2', 'apple', '56497978719', $db)
		);

		// Test failed to insert ?????????????????????????????
		$this->assertEquals(
			-1,
			processes::addEmployee('John', 'Job 2', '102', '56497978719', $db)
		);
	}

	// addShift($date, $startTime, $endTime, $employeeID, $db)
	public function testAddShift()
	{
		include("databaseClass.inc");

		// Test Success
		$this->assertEquals(
			1,
			processes::addShift('22/05/2017', '9:00', '10:00', '001', $db)
		);

		// Test end time before start time
		$this->assertEquals(
			-2,
			processes::addShift('22/05/2017', '11:00', '10:00', '001', $db)
		);

		// Test invalid employee id
		$this->assertNotEquals(
			1,
			processes::addShift('22/05/2017', '9:00', '10:00', 'apple', $db)
		);

		// test invalid start time
		$this->assertNotEquals(
			1,
			processes::addShift('22/05/2017', 'apple', '10:00', '001', $db)
		);

		// test invalid end time
		$this->assertNotEquals(
			1,
			processes::addShift('22/05/2017', '9:00', 'apple', '001', $db)
		);
  	}

  	// addServices($durationM, $businessID, $serviceName, $db)
	public function testAddServices()
	{
		include("databaseClass.inc");
		
		// Test Success
		$this->assertEquals(
			1,
			processes::addServices(20, '56497978719', 'ServiceTest', $db)
		);

		// Test invalid businessID
		$this->assertNotEquals(
			1,
			processes::addServices(20, 'apple', 'ServiceTest', $db)
		);

		// Test negative durations
		$this->assertNotEquals(
			1,
			processes::addServices(-20, '56497978719', 'ServiceTest', $db)
		);

		// Test massive durations
		$this->assertNotEquals(
			1,
			processes::addServices(99999999999999999999999, '56497978719', 'ServiceTest', $db)
		);

	}
	
	// booking($username, $abn, $date, $startTime, $endTime, $employee, $otherDetails, $activities, $db)
	public function testBooking()
	{
		include("databaseClass.inc");

		// Test successs
		$this->assertEquals(
			1,
			processes::booking('customer', '56497978719', '2017-05-19', '11:00', '11:19', '003', 'apple', 'Clip', $db)
		);

		// Test invalid employee
		$this->assertEquals(
			-2,
			processes::booking('customer', '56497978719', '2017-05-19', '11:00', '11:19', 'apple', 'apple', 'Clip', $db)
		);

		// Test employee is not working
		$this->assertEquals(
			-2,
			processes::booking('customer', '56497978719', '2017-05-19', '09:00', '09:19', '003', 'apple', 'Clip', $db)
		);

		// Test employee is booked
		$this->assertEquals(
			-1,
			processes::booking('customer', '56497978719', '2017-05-19', '11:00', '11:19', '003', 'apple', 'Clip', $db)
		);

		// Test "any" employee Succeeds
		$this->assertEquals(
			1,
			processes::booking('customer', '56497978719', '2017-05-19', '11:00', '11:19', 'any', 'apple', 'Clip', $db)
		);

		// Test "any" employee Succeeds
		$this->assertEquals(
			1,
			processes::booking('customer', '56497978719', '2017-05-19', '11:00', '11:19', 'any', 'apple', 'Clip', $db)
		);

		// Test "any" employee, no one is working
		$this->assertEquals(
			-2,
			processes::booking('customer', '56497978719', '2017-05-19', '22:00', '22:19', 'any', 'apple', 'Clip', $db)
		);

		// Test "any" employee, employee is booked
		$this->assertEquals(
			-1,
			processes::booking('customer', '56497978719', '2017-05-19', '11:00', '11:19', 'any', 'apple', 'Clip', $db)
		);

		// Test invalid abn
		$this->assertNotEquals(
			1,
			processes::booking('customer', 'apple', '2017-04-24', '11:00', '11:19', 'any', 'apple', 'Clip', $db)
		);

		// Test end time is before start time
		$this->assertNotEquals(
			1,
			processes::booking('customer', '56497978719', '2017-04-24', '12:00', '11:19', 'any', 'apple', 'Clip', $db)
		);

		// Test invalid date
		$this->assertNotEquals(
			1,
			processes::booking('customer', '56497978719', 'apple', '12:00', '12:19', 'any', 'apple', 'Clip', $db)
		);

		// test invalid start time
		$this->assertNotEquals(
			1,
			processes::booking('customer', '56497978719', '2017-04-24', 'apple', '12:19', 'any', 'apple', 'Clip', $db)
		);

		// test invalid end time
		$this->assertNotEquals(
			1,
			processes::booking('customer', '56497978719', '2017-04-24', '12:00', 'apple', 'any', 'apple', 'Clip', $db)
		);

	}
	
	// editShift($date, $startTime, $endTime, $workPeriodID, $employeeID, $action, $db)
	public static function testEditShift()
	{
		include("databaseClass.inc");

		// Test Edit Success
		$this->assertEquals(
			1,
			processes::editShift('2017-04-25', '09:00', '10:00', '1', '001', 'Edit Shift', $db)
		);

		// Test workPeriodID doesnt exist
		$this->assertNotEquals(
			1,
			processes::editShift('2017-04-25', '09:00', '10:00', 'apple', '001', 'Edit Shift', $db)
		);

		// Test Edit start time before end time
		$this->assertEquals(
			-2,
			processes::editShift('2017-04-25', '11:00', '10:00', '1', '001', 'Edit Shift', $db)
		);

		// Test Edit invalid employee id
		$this->assertNotEquals(
			1,
			processes::editShift('2017-04-25', '09:00', '10:00', '1', 'apple', 'Edit Shift', $db)
		);

		// Test Edit invalid start time
		$this->assertNotEquals(
			1,
			processes::editShift('2017-04-25', 'apple', '10:00', '1', '001', 'Edit Shift', $db)
		);

		// Test Edit invalid end time
		$this->assertNotEquals(
			1,
			processes::editShift('2017-04-25', '09:00', 'apple', '1', '001', 'Edit Shift', $db)
		);

		// Test delete success
		$this->assertEquals(
			2,
			processes::editShift('2017-04-25', '09:00', '10:00', '1', '001', 'Delete Shift', $db)
		);

		// Test delete invalid id
		$this->assertNotEquals(
			2,
			processes::editShift('2017-04-25', '09:00', '10:00', 'apple', '001', 'Delete Shift', $db)
		);

	}

	// newBusiness($password, $checkpassword, $openingTime, $closingTime, $name, $ownerName, $address, $phoneNo, $ABN, $username, $db)
	public static function testNewBusiness()
	{
		include("databaseClass.inc");
		
		// Test success
		$this->assertEquals(
			1,
			processes::newBusiness('apple', 'apple', '09:00', '18:00', 'Dingo Joe\'s', 'Joe Broe', 'Right HERE', '4', '56497978720', 'OWNERPERSON', $db)
		);

		// Test already existing ABN
		$this->assertNotEquals(
			1,
			processes::newBusiness('apple', 'apple', '09:00', '18:00', 'Dingo Joe\'s', 'Joe Broe', 'Right HERE', '4', '56497978719', 'OWNERPERSON', $db)
		);

		// Test passwords not matching
		$this->assertNotEquals(
			1,
			processes::newBusiness('apple', 'pear', '09:00', '18:00', 'Dingo Joe\'s', 'Joe Broe', 'Right HERE', '4', '56497978720', 'OWNERPERSON', $db)
		);

		// Test closing time is before opening time
		$this->assertNotEquals(
			1,
			processes::newBusiness('apple', 'apple', '09:00', '18:00', 'Dingo Joe\'s', 'Joe Broe', 'Right HERE', '4', '56497978720', 'OWNERPERSON', $db)
		);

	}
	
	// login($username, $password, $db)
	public static function testLogin()
	{
		include("databaseClass.inc");
		// Test customer Logged in
		$this->assertEquals(
			2,
			processes::login('customer', 'customer', $db)
		);

		// Test admin logged in
		$this->assertEquals(
			1,
			processes::login('admin', 'admin', $db)
		);

		// Test incorrect user name
		$this->assertEquals(
			-1,
			processes::login('apple', 'customer', $db)
		);

		// Test incorrect password
		$this->assertEquals(
			-1,
			processes::login('customer', 'apple', $db)
		);

		// Test incorrect username and password
		$this->assertEquals(
			-1,
			processes::login('apple', 'apple', $db)
		);
				
	}

	// register($username, $fullname, $address, $phone, $password, $db)
	public static function testRegister()
	{
		include("databaseClass.inc");

		// Test Success
		$this->assertEquals(
			1,
			processes::register('Pomodoro', 'Doggo', 'The House', '1234123412', 'bonezzz', $db)
		);

		// Test username is already taken
		$this->assertEquals(
			1,
			processes::register('Pomodoro', 'customer', 'The House', '1234123412', 'bonezzz', $db)
		);

	}


}

?>