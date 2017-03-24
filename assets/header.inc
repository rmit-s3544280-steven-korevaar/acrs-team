<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8' />
<link rel='stylesheet' type='text/css' href='assets/styles.css' />
<script src='assets/externalNavigationScript.js'></script>
<title>
	<?php print($page_title); ?>
</title>
</head>
<body>

<?php
/*session_start, initiate the global array $_SESSION[], used to store cross page information*/
session_start();
?>
<!-- Div used to centre page on screen -->
<div id='mainWrapper'>
<div class='centreContentBodyInDiv'>