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
<h1>Booking Summaries</h1>
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
    $sql = "select fullname, startDateTime, endDateTime, otherDetails from user as a inner join booking as b on a.username=b.username order by startDateTime desc;";
    $result = $conn->query($sql);
    $num = 1;

    if ($result->num_rows > 0) {
        echo "<table class='centreTable' border = '1'><tr><th>Customer Name</th><th>Start Date/Time</th><th>End Date/Time</th><th>Extra Details</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["fullname"]."</td><td>".$row["startDateTime"]."</td><td>".$row["endDateTime"]."</td><td>".$row["otherDetails"]."</td></tr>";
            $num += 1;
        }
        echo "</table>";
        } else {
            echo "No Bookings to Display.";
        }
    $conn->close();
?>
</div>
<!--Body End-->
<?php
include('assets/footer.inc');
?>
