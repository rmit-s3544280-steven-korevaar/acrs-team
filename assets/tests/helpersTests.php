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
  
	public function testDateFormatter() {
		$this->assertEquals(
			"2017-05-15 12:00:00",
			helpers::dateFormatter("15/05/2017", "12:00")
		);
		
		$this->assertNotEquals(
			"2017-05-15 12:00",
			helpers::dateFormatter("15/05/2017", "12:00")
		);
	}
	
	
	public function testSearchExistingEmployeeID() {
		include("databaseClass.inc");
		
		$this->assertFalse(
			helpers::searchExistingEmployeeID($db, "apple")
		);
		
		$this->assertTrue(
			helpers::searchExistingEmployeeID($db, "001")
		);
		
	}
	
  
}

?>