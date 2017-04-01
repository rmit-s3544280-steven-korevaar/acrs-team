<?php
$page_title='Customer New Booking';
include('assets/header.inc');
?>
<!--Body Start--> 
<?php
include('assets/customerBannerAndNav.inc');
?>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title>Calendar</title>
    <p>Booking Calender</p>
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
			
		events: [{
			title: 'Meeting',
			start: '2017-03-20T10:30:00',
			end: '2017-03-20T12:30:00'
		},
					
		<?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "SEPT_Assignment_Part_1";
            //Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            //Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

			$query = "SELECT * FROM booking WHERE username = '".$_SESSION['username']."'";
			$results = mysqli_query($conn,$query);

			while($row = mysqli_fetch_array($results)) {							
				print_r("{");
				print_r("title: '".$row['username']."',");
	            print_r("start: '".$row['startDateTime']."',");
				print_r("end: '".$row['endDateTime']."'");
				print_r("},");
			}
		?>
		],
		dayClick: function() {
		alert('a day has been clicked!');
		$('#calendar').fullCalendar('next');
		}})});
	</script>
<a href="customerPage.php"><button>View Summary</button></a>

<!--Body End-->
<?php
include('assets/footer.inc');
?>
