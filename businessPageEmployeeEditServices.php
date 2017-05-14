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
<tr><th>Business ID</th><th>Service Name</th><th>Duration</th><th></th></tr>
<?php
	$query = "SELECT * FROM BusinessActivity; ";
	$results = $db->select($query);

	while($row = mysqli_fetch_array($results)) {
		echo "<tr>";
		echo "<td>".$row['businessID']."</td>";
        echo "<td>".$row['activityName']."</td>";
        echo "<td>".$row['duration']."</td>";
        echo "<td><a href=businessPage.php>Edit</a></td>";
	}

?>
</table>




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
