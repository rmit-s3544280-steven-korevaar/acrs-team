function getStartTime() {
    var theForm = document.forms["bookingform"];
    var startTime =  theForm.elements["startTime"];
    return startTime.value;
}



function pad(d) {
    return (d < 10) ? '0' + d.toString() : d.toString();
}

function updateEndTime() {
	 var bookingStartTime = getStartTime();
    var theForm = document.forms["bookingform"];
    var timeSplit = bookingStartTime.split(":");
    var hours = timeSplit[0];
    var mins = timeSplit[1];
    var i;
    var duration = 0;

    var checkbox = theForm.getElementsByClassName('inlinelabel');
    

    for (i = 0; i < checkbox.length; i++) {
        if (checkbox[i].checked) {
            duration += parseInt(checkbox[i].getAttribute('duration').split(":")[1]);
        } 
    }

    
    mins = parseInt(mins) + parseInt(duration);
    hours = parseInt(parseInt(hours) + (mins/60));
    mins = mins % 60;

    var currentTime = hours + ':' + pad(mins);
	 if (hours <= 9)
	 {
		 document.getElementById('endTime').value = '0'+ currentTime;
	 }
	 else
	 {
		 document.getElementById('endTime').value = currentTime;
	 }
    
  
}
