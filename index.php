<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script to generate the html login page.
 * 
 ********************************************************************/
$page_title='Choose Business';
include('./assets/header.inc');
/* Instantiate database connection object, called $db */
include('./assets/databaseClass.inc');
?>
<!--Body Start--> 
<div class='centreContentBodyInDiv'>
<div class='headingBannerDiv'>
<h1>Select a Business</h1>
</div>
<!--Choose Business Portion of index.php-->
<?php
$results = $db->select("SELECT * FROM business;");
if(mysqli_num_rows($results) != 0)
{
	while($row=mysqli_fetch_array($results))
	{
		print "<a href='./assets/processForms/processSelectBusiness.php?abn={$row['ABN']}&businessName={$row['name']}'><div class='businessFrame'><img class='choosebusinessImage' src='./assets/images/businessImage/dogGroomer.png'><h3>{$row['name']}</h3></div></a>";
	}
}
else
{
	print "<table><tr><h2>No Businesses Found</h2></tr></table>";
}
?>
<!--Body End-->
<?php
include('assets/footer.inc');
?>