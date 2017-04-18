<?php 
	class Database{
	// The database connection object
	protected static $connection;

	/**
	* Function to connect to the database using config file, check if it is valid
	* Return false if failed and add any logging.
	*/
	public function connect(){
	// Check if connection is valid
	if(!isset(self::$connection)) {
		/* Load config from ini file */
		$config = parse_ini_file('./../config.ini'); 
		//We use self to refer to a static object inside the class, where as this is for non static members.
		self::$connection = new mysqli($config['address'],$config['username'],$config['password'],$config['dbname']);

		/**
		* Put logging feature here for successful connection to database
		*/
	}

		// If connection was not successful, return error for logging
		if(self::$connection === false){
			/**
			* Put logging feature here for unsuccessful connection 
			*/
			return false;
		}
		return self::$connection;
	}

	/**
	* Function to query the database
	*/
	public function query($query){
		// Connect to the database
		$connection = $this -> connect();

		// Query the database
		$result = $connection -> query($query);

		return $result;
	}

	/**
	* SELECT query operation
	* Return false if failed and add other logging.
	*/
	public function select($query){
		$result = $this -> query($query);
		if($result === false) {
			/**
			* Put logging feature here for unsuccessful SELECT query 
			*/
			return false;
		}
		/**
		* Put logging feature here for successful SELECT query 
		*/
		return $result;
	}
	
	/**
	* INSERT query operation
	* Return false if failed and add other logging.
	*/
	public function insert($query){
		$result = $this -> query($query);
		if($result === false) {
			/**
			* Put logging feature here for unsuccessful INSERT query 
			*/
			return false;
		}
		/**
		* Put logging feature here for successful INSERT query 
		*/
		return $result;
	}

	/**
	* Fetch the last error from the database for debugging.
	*/
	public function error(){
		$connection = $this -> connect();
		return $connection -> error;
	}
}