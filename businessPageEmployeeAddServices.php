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
<h1>Existing Services</h1>
<table class='centreTable' border = '1'>
<tr><th>Service Name</th><th>Duration(hour:min:sec)</th></tr>
<?php
	$query = "SELECT * FROM BusinessActivity WHERE businessID = '{$_SESSION['abn']}'; ";
	$results = $db->select($query);

	while($row = mysqli_fetch_array($results)) {
		echo "<tr>";
		echo "<td>".$row['activityName']."</td>";
		echo "<td>".$row['duration']."</td>";
		echo "</tr>";
	}

?>
</table>




<div class='contentHere'>
<h1>Add a new service</h1>
<form method='post' action='./assets/processForms/processAddServices.php'>
<table class="centreTable">
<tr>
<th>Service name: </th>
<td><input type="text" name="serviceName"/></td>
</tr>
<tr>
<th>Duration(Minutes): </th>
<td><input type="text" name="durationM"/></td>
</tr>
</table>
<input type="submit" value="Add"/>




<?php
if(isset($_SESSION['returnError']) && !empty($_SESSION['returnError'])){
	print("<table class='centreTable'>\n");
	print("<tr><td class='errorMessage'>\n");
	print("<p> {$_SESSION['returnError']} </p>\n");
	print("</td></tr>\n");
	print("</table>\n");
	unset($_SESSION['returnError']);
}
elseif(isset($_SESSION['returnSuccess']) && !empty($_SESSION['returnSuccess'])){
	print("<table class='centreTable'>\n");
	print("<tr><td class='successMessage'>\n");
	print("<p> {$_SESSION['returnSuccess']} </p>\n");
	print("</td></tr>\n");
	print("</table>\n");
	unset($_SESSION['returnSuccess']);
}
?>
</form>
</div>
</div>





<!--Body End-->
<?php
include('./assets/footer.inc');
?>
