/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * External javascript used for business navigation drop down boxes.
 * 
 ********************************************************************/
function navigateBooking(){
	var menu = document.getElementById("businessNavigationBooking");
	var url = menu.options[menu.selectedIndex].value;
	location.href=url;
}
function navigateEmployee(){
	var menu = document.getElementById("businessNavigationEmployee");
	var url = menu.options[menu.selectedIndex].value;
	location.href=url;
}