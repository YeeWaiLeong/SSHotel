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

if(!$data)
{
    $status["Status"] = "Failed, data is empty";
}
else
{
    $sql = "insert into submission (idassessment, name, department, staff_id, date)
    values ('".$data['assessment_id']."', '".$data['name']."', '".$data['department']."', '".$data['staff_id']."', '".$data['date']."')";

    if($conn->query($sql) === true)
    {
        $last_id = $conn->insert_id;
        $answers = $data['answers'];
        foreach($answers as $ans)
        {
            $sql = "insert into answers (idassessment, idsubmission, idquestions, content)
            values ('".$data['assessment_id']."', '".$last_id."', '".$ans[0]."', '".$ans[1]."')";

            if($conn->query($sql) === true)
            {
                //do nothing
            }
            else
            {
                $status["Status"] = "Failed, db answer insert error. $conn->error";
            }
        }
    }
    else
    {
        $status["Status"] = "Failed, db submission insert error. $conn->error";
    }
}

$conn -> close();
echo json_encode($status);
?>