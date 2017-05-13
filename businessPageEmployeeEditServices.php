<?php
/* *******************************************************************


 ********************************************************************/
	$page_title='Edit Services';
	include('./assets/header.inc');
	/* Instantiate database connection object, called $db */
	include('./assets/databaseClass.inc');
?>

<!--Body Start--> 
<?php
include('./assets/ownerChecker.inc');
include('./assets/businessBannerAndNav.inc');
?>
<div class='contentHereDiv'>
<h1>Edit Services</h1>
service 1			<input type="submit" value="Edit"/> <input type="submit" value="Delete"/><br/>
service 2			<input type="submit" value="Edit"/> <input type="submit" value="Delete"/><br/>
service 3			<input type="submit" value="Edit"/> <input type="submit" value="Delete"/>



<div class='contentHere'>
<h1>Add a new service</h1>
<form method='post' action='./assets/processForms/processAddServices.php'>
<table class="centreTable">
<tr>
<th>Business ID: </th>
<td><input type="text" name="businessID"/></td>
</tr>
<tr>
<th>Service name: </th>
<td><input type="text" name="serviceName"/></td>
</tr>
<tr>
<th>Duration: </th>
<td><input type="time" name="duration"/></td>
</tr>
</table>
<input type="submit" value="Add"/>



<?php
if(isset($_SESSION['returnErrorAddServiceMessage2']) && !empty($_SESSION['returnErrorAddServiceMessage2'])){
	print("<table class='centreTable'>\n");
	print("<tr><td class='errorMessage'>\n");
	print("<p> {$_SESSION['returnErrorAddServiceMessage2']} </p>\n");
	print("</td></tr>\n");
	print("</table>\n");
	unset($_SESSION['returnErrorAddServiceMessage2']);
}
elseif(isset($_SESSION['returnSuccessAddServiceMessage']) && !empty($_SESSION['returnSuccessAddServiceMessage'])){
	print("<table class='centreTable'>\n");
	print("<tr><td class='successMessage'>\n");
	print("<p> {$_SESSION['returnSuccessAddServiceMessage']} </p>\n");
	print("</td></tr>\n");
	print("</table>\n");
	unset($_SESSION['returnSuccessAddServiceMessage']);
}
?>
</form>
</div>
</div>





<!--Body End-->
<?php
include('./assets/footer.inc');
?>
