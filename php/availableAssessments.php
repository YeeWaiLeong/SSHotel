<?php
$response = array("response" => "Error");

mysqli_report(MYSQLI_REPORT_OFF);
// Create connection
$conn = new mysqli("localhost", "root", "", "sshotel");

if($conn->connect_error)
{
    die("Failed to connect to MySQL server");
}

$sql = "select * from assessment";
$result = $conn->query($sql);

if($result->num_rows > 0)
{
    $response['response'] = "OK";
    while($row = $result->fetch_assoc())
    {
        $assessment = array($row["idassessment"], $row["title"], $row["description"], $row["minimumScore"], $row["totalScore"], $row["numberOfQuestion"]);
        array_push($response, $assessment);
    }
}
else
{
    $response['response'] = "No results";
}

$conn->close();
echo json_encode($response);
?>