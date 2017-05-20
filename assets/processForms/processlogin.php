<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script used to process the user login.
 *
 * The script will check if the username AND password combination 
 * exists in the user table.
 *
 * If not it will redirect back to the login page with a error 
 * message.
 *
 * If it does, check whether if it a business owner or a customer, and
 * redirect appropriately.
 * 
 ********************************************************************/
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");
 
 /* Instantiate database */
include('./databaseClass.inc');
require_once('processes.php');
 
$username = $_POST['username'];
$password = $_POST['password'];
		
processes::login($username, $password, $db, $logger);
 
exit(0);
?>