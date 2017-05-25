<?php

require_once("../helpers.php");
require_once("../processForms/processes.php");
//require_once("databaseMock.php");

class helpersTest extends PHPUnit_Framework_TestCase 
{
	
	protected function setUp() {}

	protected function tearDown() {}

	// timeCheck($start, $end)
	public function testTimeCheck() 
	{
		$this->assertFalse(
			helpers::timeCheck("14:00:00","13:00:00")
		);
	
		$this->assertTrue(
			helpers::timeCheck("12:00:00","13:00:00")
		);
		
		$this->assertTrue(
			helpers::timeCheck("13:00:00","13:00:00")
		);
	}
  
	// dateFormatter($date, $time)
	public function testDateFormatter() 
	{
		$this->assertEquals(
			"2017-05-15 12:00:00",
			helpers::dateFormatter("15/05/2017", "12:00")
		);
		
		$this->assertNotEquals(
			"2017-05-15 12:00",
			helpers::dateFormatter("15/05/2017", "12:00")
		);
	}
	
	// checkValidDuration($time)
	public function testValidDuration() 
	{
		$this->assertTrue(
			helpers::checkValidDuration('00:60:00')
		);
		
		$this->assertTrue(
			helpers::checkValidDuration('00:01:00')
		);
		
		$this->assertFalse(
			helpers::checkValidDuration('00:00:00')
		);
		
		$this->assertFalse(
			helpers::checkValidDuration('01:01:00')
		);
		
	}
	
	//serviceDurationFormatter($durationM)
	public function testDurationFormatter() 
	{
		$this->assertEquals(
			"01:00:00",
			helpers::serviceDurationFormatter('60.0')
		);
		
		$this->assertEquals(
			"00:30:00",
			helpers::serviceDurationFormatter(30)
		);
		
		$this->assertEquals(
			"00:59:00",
			helpers::serviceDurationFormatter(59)
		);
	}
	
	// searchExistingEmployeeID($db,$employeeID)
	// searchExistingEmployeeIDset($db,$employeeID, $abn)
	public function testSearchExistingEmployeeID()
	{
		include("databaseClass.inc");
		
		$this->assertFalse(
			helpers::searchExistingEmployeeIDset($db, "apple", '56497978719')
		);
		
		$this->assertTrue(
			helpers::searchExistingEmployeeIDset($db, "001", '56497978719')
		);
	}
	
	// isEmpWorking($emp, $startDT, $endDT, $db)
	public function testIsEmpWorking() 
	{
		include("databaseClass.inc");

		//workPeriod values(null,"2017-04-26 09:00:00","2017-04-26 15:00:00","002"); --(emp-002, wed 26/04, 9am-3pm)
		
		// Invalid employee ID
		$this->assertNotEquals(
			1,
			helpers::isEmpWorking('apple', '2017-04-26 10:00:00', '2017-04-26 11:00:00', $db)
		);
		
		// Full inside bounds
		$this->assertEquals(
			1,
			helpers::isEmpWorking('002', '2017-04-26 10:00:00', '2017-04-26 11:00:00', $db)
		);

		// Full out of bounds
		$this->assertNotEquals(
			1,
			helpers::isEmpWorking('002', '2017-04-26 01:00:00', '2017-04-26 02:00:00', $db)
		);

		// Half out of bounds forward
		$this->assertNotEquals(
			1,
			helpers::isEmpWorking('002', '2017-04-26 14:00:00', '2017-04-26 16:00:00', $db)
		);

		// Half out of bounds backwards
		$this->assertNotEquals(
			1,
			helpers::isEmpWorking('002', '2017-04-26 01:00:00', '2017-04-26 10:00:00', $db)
		);
		
	}
	
	// isEmpBooked($emp, $startDT, $endDT, $db) 
	public function testIsEmpBooked() 
	{
		//workPeriod values(null,"2017-04-27 12:00:00","2017-04-27 18:00:00","002"); --(emp-002, thur 27/04, 12pm-6pm)
		$_SESSION['abn'] = '56497978719';
		include("databaseClass.inc");
		
		processes::booking('customer', '56497978719', '19/05/2017', '11:00', '11:19', '003', 'apple', ['Clip'], $db);
		
		// Full inside bounds
		$this->assertNotEquals(
			1,
			helpers::isEmpBooked('003', '2017-05-19 11:01:00', '2017-05-19 11:18:00', $db)
		);

		// Full out of bounds
		$this->assertEquals(
			1,
			helpers::isEmpBooked('003', '2017-05-19 01:00:00', '2017-05-19 02:00:00', $db)
		);

		// Half out of bounds forward
		$this->assertNotEquals(
			1,
			helpers::isEmpBooked('003', '2017-05-19 11:15:00', '2017-05-19 12:00:00', $db)
		);

		// Half out of bounds backwards
		$this->assertNotEquals(
			1,
			helpers::isEmpBooked('003', '2017-05-19 10:00:00', '2017-05-19 11:10:00', $db)
		);
		
	}
	
	// findAvailableEmp($startDT, $endDT, $db)
	public function testFindAvailableEmp() 
	{
		include("databaseClass.inc");
		$_SESSION['abn'] = '56497978719';
		
		processes::booking('customer', '56497978719', '19/05/2017', '11:00', '11:19', '003', 'apple', ['Clip'], $db);
		
		processes::booking('customer', '56497978719', '19/05/2017', '11:00', '11:19', '001', 'apple', ['Clip'], $db);
		processes::booking('customer', '56497978719', '19/05/2017', '11:00', '11:19', '002', 'apple', ['Clip'], $db);
		
		// Full success
		$this->assertNotEquals(
			-1,
			helpers::findAvailableEmp('2017-05-19 11:30:00', '2017-05-19 11:50:00', $db)
		);

		// Inside Booking
		$this->assertEquals(
			-1,
			helpers::findAvailableEmp('2017-05-19 11:01:00', '2017-05-19 11:18:00', $db)
		);

		// Half out of bounds forward Booking
		$this->assertEquals(
			-1,
			helpers::findAvailableEmp('2017-05-19 11:10:00', '2017-05-19 11:25:00', $db)
		);

		// Half out of bounds backwards Booking
		$this->assertEquals(
			-1,
			helpers::findAvailableEmp('2017-05-19 10:01:00', '2017-05-19 11:10:00', $db)
		);
		
		
		// Outside Work Period
		$this->assertEquals(
			-1,
			helpers::findAvailableEmp('2017-05-19 01:00:00', '2017-05-19 02:00:00', $db)
		);

		// Half out of bounds forward Work Period
		$this->assertEquals(
			-1,
			helpers::findAvailableEmp('2017-05-19 17:30:00', '2017-05-19 19:30:00', $db)
		);

		// Half out of bounds backwards Work Period
		$this->assertEquals(
			-1,
			helpers::findAvailableEmp('2017-05-19 08:30:00', '2017-05-19 09:30:00', $db)
		);
		
	}
	
	// checkOverlap($startDateTime, $endDateTime, $employeeID, $workperiodID, $db)
	public function testCheckOverlap() 
	{
		include("databaseClass.inc");
		
		// Check no overlap
		$this->assertTrue(
			helpers::checkOverlap('2017-05-19 09:00:00', '2017-05-19 10:00:00', 
			'002', '28', $db)
		);
		// Check total overlap
		$this->assertFalse(
			helpers::checkOverlap('2017-05-19 12:00:00', '2017-05-19 13:00:00', 
			'002', '28', $db)
		);

		// Check half overlap forward
		$this->assertFalse(
			helpers::checkOverlap('2017-05-19 14:30:00', '2017-05-19 15:30:00', 
			'002', '28', $db)
		);

		// Check half overlap backwards
		$this->assertFalse(
			helpers::checkOverlap('2017-05-19 08:30:00', '2017-05-19 11:30:00', 
			'002', '28', $db)
		);

	}
		
	// checkPassword($password, $checkpassword)
	public function testCheckPassword() 
	{
		include("databaseClass.inc");
		
		// Test that two passwords are the same
		$this->assertTrue(helpers::checkPassword('apple', 'apple'));

		// Test first is different
		$this->assertFalse(helpers::checkPassword('pear', 'apple'));

		// Test second is different
		$this->assertFalse(helpers::checkPassword('apple', 'pear'));
	}

	// validTime($value)
	public function testValidTime()
	{
		$this->assertEquals(
			1,
			helpers::validTime('01:00')
		);
		
		$this->assertEquals(
			1,
			helpers::validTime('23:59')
		);
		
		$this->assertNotEquals(
			1,
			helpers::validTime('23:79')
		);
		
		$this->assertNotEquals(
			1,
			helpers::validTime('25:00')
		);
		
		$this->assertEquals(
			1,
			helpers::validTime('01:00:00')
		);
		
		$this->assertEquals(
			1,
			helpers::validTime('23:59:00')
		);
		
		$this->assertNotEquals(
			1,
			helpers::validTime('23:79:00')
		);
		
		$this->assertNotEquals(
			1,
			helpers::validTime('25:00:00')
		);
		
		$this->assertNotEquals(
			1,
			helpers::validTime('23:59:79')
		);
		
		$this->assertNotEquals(
			1,
			helpers::validTime('25:00:00')
		);
		
		
		$this->assertNotEquals(
			1,
			helpers::validTime('apple')
		);
	}
	
	// insideBusinessHours($startDateTime,$endDateTime,$abn,$db)
	public function testBusinessHoursOverlap()
	{
		include("databaseClass.inc");
		
		// Check inside bounds
		$this->assertEquals(
			1,
			helpers::insideBusinessHours('2017-05-19 12:00:00', '2017-05-19 15:00:00', 
			'56497978719', $db)
		);
		
		// Check fully outside
		$this->assertEquals(
			0,
			helpers::insideBusinessHours('2017-05-19 00:00:00', '2017-05-19 01:00:00', 
			'56497978719', $db)
		);
		
		// half in forwards
		$this->assertEquals(
			0,
			helpers::insideBusinessHours('2017-05-19 12:00:00', '2017-05-19 23:00:00', 
			'56497978719', $db)
		);
		
		// half in backwards
		$this->assertEquals(
			0,
			helpers::insideBusinessHours('2017-05-19 00:00:00', '2017-05-19 12:00:00', 
			'56497978719', $db)
		);
		
	}
  
}

?>