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