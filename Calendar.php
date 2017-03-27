

<!DOCTYPE html>
<meta charset = "UTF-8">

<html>
    
    
    <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		
		<title>Calendar</title>

		<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
		<script src='lib/jquery.min.js'></script>
		<script src='lib/moment.min.js'></script>
		<script src='fullcalendar/fullcalendar.js'></script>
	
    </head>
    
    
    <body>
	
		<div id='calendar'></div>
	
    </body>
    
    <script>
		$(document).ready(function() {

		
			
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				defaultView: 'basicDay',
				editable: true,
			
				events: [
					/*{
						title: 'Meeting',
						start: '2017-03-20T10:30:00',
						end: '2017-03-20T12:30:00'
					},*/
					
					<?php
						$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
						$query = "select * from booking";
						$results = mysqli_query($connect,$query) or die(mysqli_error($connect));
						while($row = mysqli_fetch_array($results)) {
							//print_r($row);
							
							print_r("{
								");
							print_r("title: '".$row['username']."',
							");
							print_r("start: '".$row['startDateTime']."',
							");
							print_r("end: '".$row['endDateTime']."'
							");
							print_r("},
							");
						}
					?>
				],
				
				dayClick: function() {
					//alert('a day has been clicked!');
					//$('#calendar').fullCalendar('next');
				}
				
			})

		});
	</script>
</html>
