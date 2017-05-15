<?php

require_once("mysqliMock.php");

class databaseMock
{
	
	public $db;
	
	public function __construct( )
    {

    }
	
	public function select($query){

		$result = new mysql_result();
	
		if($result === false) {
			return false;
		}
		return $result;
	}
	

	public function insert($query){
		$result = $this -> query($query);
		if($result === false) {
			return false;
		}
		return $result;
	}
	

	public function update($query){
		$result = $this -> query($query);
		if($result === false) {
			return false;
		}
		return $result;
	}
	
	
	public function delete($query){
		$result = $this -> query($query);
		if($result === false) {
			return false;
		}
		return $result;
	}

	
	public function error(){
		$connection = $this -> connect();
		return $connection -> error;
	}
	
}


?>