<?php
$page_title='Login';
include('assets/header.inc');
?>
<!--Body Start--> 
<div class='centreContentBodyInDiv'>
<div class='headingBannerDiv'>
<h1><img src="https://s-media-cache-ak0.pinimg.com/originals/5b/92/41/5b92414b99b103faf46490d3f8234a20.png" width="100" height="65" alt="bear" />Appointment Booking System</h1>
</div>
<div class='instructionsIndexDiv'>
<p>Customers - 'Login' to see booking status and to make new bookings.</p>
<p>If you do not have an account, please 'Register' and then login.</p>
<p>Owners - 'Login' to see more functionalities.</p>
</div>
<!--Login Portion of index.php-->
<div id='loginForm'>
<div class='formBorder'>
<h1>Login</h1>
<form method='post' action="./assets/processForms/processlogin.php">
<table class="centreTable">
<tr>
<th>Username: </th>
<td><input type="text" name="username"/></td>
</tr>
<tr>
<th>Password: </th>
<td><input type="password" name="password"/></td>
</tr>
</table>
<table class="centreTable">
<tr><td><input type="submit" value="Login"/></td></tr>

<?php
if(isset($_SESSION['loginError']) && !empty($_SESSION['loginError'])){
	print("<tr><td class='errorMessage'>\n");
	print("<p> {$_SESSION['loginError']} </p>\n");
	print("</td></tr>\n");
	unset($_SESSION['loginError']);
}
?>
</table>
</form>
</div>
</div>

<!--Register Portion of index.php-->
<div id='registerForm'>
<div class='formBorder'>
<h1>Customer Register</h1>
<form method="post" action="./assets/processForms/processRegister.php">
<table class="centreTable">
<tr>
<th>Username: </th>
<td><input type="text" name="username" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][0]}'";} ?>/></td>
</tr>
<tr>
<th>Password: </th>
<td><input type="password" name="password" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][1]}'";} ?>/></td>
</tr>
<tr>
<th>Full name: </th>
<td><input type="text" name="fullname" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][2]}'";} ?>/></td>
</tr>
<tr>
<th>Address: </th>
<td><input type="text" name="address" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][3]}'";} ?>/></td>
</tr>
<tr>
<th>Phone Number: </th>
<td><input type="text" name="phone" <?php if(isset($_SESSION['returnData'])){print "value='{$_SESSION['returnData'][4]}'";} ?>/></td>
</tr>
</table>
<table class="centreTable">
<tr><td><input type="submit" value="Register"/></td></tr>
<?php
/*Check if return data from processRegister.php is set, unset after use.*/
if(isset($_SESSION['returnData']) && !empty($_SESSION['returnData'])){
	print("<tr><td class='errorMessage'>\n");
	print("<p> {$_SESSION['registerError']} </p>\n");
	print("</td></tr>\n");
	unset($_SESSION['returnData']);
	unset($_SESSION['registerError']);
}
/*Prints out error message if set*/
if(isset($_SESSION['registerError']) && !empty($_SESSION['registerError'])){
	print("<tr><td class='errorMessage'>\n");
	print("<p> {$_SESSION['registerError']} </p>\n");
	print("</td></tr>\n");
	unset($_SESSION['registerError']);
}
elseif(isset($_SESSION['registerSuccess']) && !empty($_SESSION['registerSuccess'])){
	print("<tr><td class='successMessage'>\n");
	print("<p> {$_SESSION['registerSuccess']} </p>\n");
	print("</td></tr>\n");
	unset($_SESSION['registerSuccess']);
}
?>
</table>
</form>
</div>
</div>

</div>
<!--Body End-->
<?php
include('assets/footer.inc');
?>
