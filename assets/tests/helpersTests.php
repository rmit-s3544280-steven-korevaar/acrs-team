<?php

require_once("../helpers.php");
//require_once("databaseMock.php");

class helpersTest extends PHPUnit_Framework_TestCase 
{
	
	protected function setUp() {}

	protected function tearDown() {}

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
	
	
	public function testSearchExistingEmployeeID()
	{
		include("databaseClass.inc");
		
		$this->assertFalse(
			helpers::searchExistingEmployeeID($db, "apple")
		);
		
		$this->assertTrue(
			helpers::searchExistingEmployeeID($db, "001")
		);
	}
	
	
	// isEmpWorking($emp, $startDT, $endDT, $db)
	public function testIsEmpWorking() 
	{
		include("databaseClass.inc");

		// Full inside bounds

		// Full out of bounds

		// Half out of bounds forward

		// Half out of bounds backwards
		
	}
	
	// isEmpBooked($emp, $startDT, $endDT, $db) 
	public function testIsEmpBooked() 
	{
		include("databaseClass.inc");

		// Full inside bounds

		// Full out of bounds

		// Half out of bounds forward

		// Half out of bounds backwards
		
	}
	
	// findAvailableEmp($startDT, $endDT, $db)
	public function testFindAvailableEmp() 
	{
		include("databaseClass.inc");

		// Full success

		// Full out of bounds

		// Half out of bounds forward

		// Half out of bounds backwards
		
	}
	
	// checkOverlap($startDateTime, $endDateTime, $employeeID, $workperiodID, $db)
	public function testCheckOverlap() 
	{
		include("databaseClass.inc");
		
		// Check no overlap

		// Check total overlap

		// Check half overlap forward

		// Check half overlap backwards

	}
		
	// checkPassword($password, $checkpassword)
	public function testCheckPassword() 
	{
		include("databaseClass.inc");
		
		// Test that two passwords are the same
		$this->assertTrue(checkPassword('apple', 'apple'));

		// Test first is different
		$this->assertFalse(checkPassword('pear', 'apple'));

		// Test second is different
		$this->assertFalse(checkPassword('apple', 'pear'));
	}

  
}

?>