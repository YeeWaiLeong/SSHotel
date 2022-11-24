<?php
$json = file_get_contents("php://input");
$status = array("Status" => "OK");

mysqli_report(MYSQLI_REPORT_OFF);
// Create connection
$conn = new mysqli("localhost", "root", "", "sshotel");
if($conn->connect_error)
{die("Failed to connect to MySQL server");}

//turn off STRICT_TRANS_TABLES to not cause insert error
$sql = "set global sql_mode=''";
$conn->query($sql);
$conn->close();

$conn = new mysqli("localhost", "root", "", "sshotel");
if($conn->connect_error)
{die("Failed to connect to MySQL server");}

$data = json_decode($json, true);
$subID = $data['subID'];
$score = $data['score'];

$sql = "UPDATE submission 
SET score = $score, markStatus = 1
WHERE idsubmission = $subID";

if($conn->query($sql) === true)
{
    //do nothing
}
else
{
    $status['Status'] = "Failed to update submission, $conn->error";
}

$conn->close();
echo json_encode($status);
?>