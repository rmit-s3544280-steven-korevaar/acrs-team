<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * Include header file to generate HTML Document.
 *
 * 
 ********************************************************************/
include('./datalogging/Logger.php');
Logger::configure('./config.xml');
$logger = Logger::getLogger("main");
?>
<!DOCTYPE html>
<html>
<head>

<!-- Default header elements -->
<meta charset='UTF-8' />
<link rel='stylesheet' type='text/css' href='./assets/styles.css' />
<link href='//fonts.googleapis.com/css?family=Prata' rel='stylesheet'>
<link href='//fonts.googleapis.com/css?family=Fenix' rel='stylesheet'>
<script src='./assets/externalNavigationScript.js'></script>
<title>
	<?php print($page_title); ?>
</title>

<!-- Header elements for fullCalendar embedded component -->
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
<link rel='stylesheet' href='assets/calendar/fullcalendar/fullcalendar.css' />
<script src='./assets/calendar/lib/jquery.min.js'></script>
<script src='./assets/calendar/lib/moment.min.js'></script>
<script src='./assets/calendar/fullcalendar/fullcalendar.js'></script>

<script src="./assets/booking.js"></script>

</head>
<body>

<?php
/*session_start, initiate the global array $_SESSION[], used to store cross page information*/
session_start();
?>
<!-- Div used to centre page on screen -->
<div id='mainWrapper'>
<div class='centreContentBodyInDiv'>