<?php
$id = file_get_contents("php://input");
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

$sql = "DELETE FROM assessment WHERE idassessment = $id";

if($conn->query($sql) === true)
{
    //$sql = $conn->query("ALTER TABLE assessment AUTO_INCREMENT = 1"); doesnt work
}
else
{
    $status['Status'] = "Failed to delete assessment, $conn->error";
}

$conn->close();
echo json_encode($status);
?>