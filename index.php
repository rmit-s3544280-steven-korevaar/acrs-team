<?php
$page_title='Login';
include('/assets/header.inc');
?>
<!--Body Start--> 
<div class='centreContentBodyInDiv'>
<div class='headingBannerDiv'>
<h1>Booking Website</h1>
</div>
<div class='instructionsIndexDiv'>
<p>Customers - Login' to see booking status and to make new bookings.</p>
<p>If you do not have an account, please 'Register' and then login.</p>
<p>Owners - 'Login' to see more functionalities.</p>
</div>
<!--Login Portion of index.php-->
<div id='loginForm'>
<div class='formBorder'>
<h1>Login</h1>
<form method='post' action='processlogin.php'>
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

<form method="post" action="processRegister.php">
<table class="centreTable">
<tr>
<th>Username: </th>
<td><input type="text" name="username"/></td>
</tr>
<tr>
<th>Password: </th>
<td><input type="password" name="password"/></td>
</tr>
<tr>
<th>Full name: </th>
<td><input type="text" name="fullname"/></td>
</tr>
<tr>
<th>Address: </th>
<td><input type="text" name="address"/></td>
</tr>
<tr>
<th>Phone Number: </th>
<td><input type="text" name="phone"/></td>
</tr>
</table>
<table class="centreTable">
<tr><td><input type="submit" value="Register"/></td></tr>
<?php
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
