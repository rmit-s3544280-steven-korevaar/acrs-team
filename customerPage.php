<?php
$page_title='Customer Booking Summaries';
include('/assets/header.inc');
?>
<!--Body Start--> 
<?php
include('assets/customerBannerAndNav.inc');
?>
<div class='contentHereDiv'>
<p>Your Booking Summaries</p>
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
    $sql = "SELECT startDateTime, endDateTime, otherDetails, username FROM booking WHERE username = '".$_SESSION['username']."'";
    $result = $conn->query($sql);
    $num = 1;

    if ($result->num_rows > 0) {
        echo "<table border = '1'><tr><th>No.</th><th>Start Time</th><th>End Time</th><th>Details</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$num."</td><td>".$row["startDateTime"]."</td><td>".$row["endDateTime"]."</td><td>".$row["otherDetails"]."</td></tr>";
            $num += 1;
        }
        echo "</table>";
        } else {
            echo "No Bookings to Display.";
        }
    $conn->close();
?>
<a href="customerBooking.php"><button>View Calender</button></a>
</div>
<!--Body End-->
<?php
include('assets/footer.inc');
?>

