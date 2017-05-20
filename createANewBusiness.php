<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script to generate the html login page.
 * 
 ********************************************************************/
$page_title='Create a new Business';
include('./assets/header.inc');
/* Instantiate database connection object, called $db */
include('./assets/databaseClass.inc');
?>
<!--Body Start--> 
<div class='headingBannerDiv'>
<h1>Create a new Business</h1>
<span class='indexSpan'>Or</span>
<a href='index.php' ><span class='indexSpan'>Click here to go back to Selecting Businesses</span></a>
</div>
<!--Choose Business Portion of index.php-->
<form method='post' action='./assets/processForms/processNewBusiness.php' enctype='multipart/form-data'>
<h4>Business details</h4>
<table class="centreTable">
<tr>
<th>Business name: </th>
<td><input type="text" name="name" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][0]}'";} ?>/></td>
</tr>
<tr>
<th>Business owners name: </th>
<td><input type="text" name="ownerName" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][1]}'";} ?>/></td>
</tr>
<tr>
<th>Address: </th>
<td><input type="text" name="address" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][2]}'";} ?>/></td>
</tr>
<tr>
<th>Business Phone Number: </th>
<td><input type="text" name="phoneNo" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][3]}'";} ?>/></td>
</tr>
<tr>
<th>Opening Time: </th>
<td><input type="time" name="openingTime" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][4]}'";} ?>/></td>
</tr>
<tr>
<th>Closing Time: </th>
<td><input type="time" name="closingTime" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][5]}'";} ?>/></td>
</tr>
<tr>
<th>Australian Business Number: </th>
<td><input type="text" name="ABN" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][6]}'";} ?>/></td>
</tr>
<tr>
<th>Image:</th>
<td><input type="file" name="image" /></td>
</tr>
</table>
<!--Create an admin account for the business-->
<h4>Administration account details</h4>
<table class="centreTable">
<tr>
<th>Username: </th>
<!--Username length between 5-10 and no numeric-->
<td><input type="text" name="username" pattern="[a-zA-Z0-9]{5,10}" title="Letters/Digits and length between 5-10" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][7]}'";} ?>/></td>
</tr>
<tr>
<th>Password: </th>
<td><input type="password" name="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" title="-At least 8 characters
-Must contain at least 1 uppercase letter, 1 lowercase letter, and 1 number
-Can contain special characters"/></td>
</tr>
<th>Re-enter Password: </th>
<td><input type="password" name="checkpassword" /></td>
</tr>

<table class="centreTable">
<tr><td><input type="submit" value="Create new Business"/></td></tr>
</table>

<?php
if(isset($_SESSION['registerError']) && !empty($_SESSION['registerError'])){
	print("<table class='centreTable'>\n");
	print("<tr><td class='errorMessage'>\n");
	print("<p> {$_SESSION['registerError']} </p>\n");
	print("</td></tr>\n");
	print("</table>\n");
	unset($_SESSION['registerError']);
	if(isset($_SESSION['returnData']) && !empty($_SESSION['returnData'])){
		unset($_SESSION['returnData']);
	}
}
elseif(isset($_SESSION['registerSuccess']) && !empty($_SESSION['registerSuccess'])){
	print("<table class='centreTable'>\n");
	print("<tr><td class='successMessage'>\n");
	print("<p> {$_SESSION['registerSuccess']} </p>\n");
	print("</td></tr>\n");
	print("</table>\n");
	unset($_SESSION['registerSuccess']);
}
?>
</form>
<!--Body End-->
<?php
include('assets/footer.inc');
?>