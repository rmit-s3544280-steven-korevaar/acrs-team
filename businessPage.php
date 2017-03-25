<?php
    $page_title='Business Page';
    include('/assets/header.inc');
?>
<!--Body Start--> 
<?php
    include('assets/ownerChecker.inc');
    include('assets/businessBannerAndNav.inc');
?>

<div class='contentHereDiv'>
<p>Booking Summaries</p>
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
    $sql = "SELECT username, startDateTime, endDateTime FROM booking";
    $result = $conn->query($sql);
    $num = 1;

    if ($result->num_rows > 0) {
        echo "<table border = '1'><tr><th>No.</th><th>Customer</th><th>Start Time</th><th>End Time</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$num."</td><td>".$row["username"]."</td><td>".$row["startDateTime"]."</td><td>".$row["endDateTime"]."</td></tr>";
            $num += 1;
        }
        echo "</table>";
        } else {
            echo "No Bookings to Display.";
        }
    $conn->close();
?>
<a href="calenderPage.php"><button>View Calender</button></a>
</div>
<!--Body End-->
<?php
include('assets/footer.inc');
?>
