<?php
$id = file_get_contents("php://input");
$response = array("response" => "Error");

mysqli_report(MYSQLI_REPORT_OFF);
// Create connection
$conn = new mysqli("localhost", "root", "", "sshotel");

if($conn->connect_error)
{
    die("Failed to connect to MySQL server");
}

//testing purpose
//$id = "1";

require_once("functions.php");

$sql = "select title, description, numberOfQuestion from assessment where assessment.idassessment = $id";
$array = array("title", "description", "numberOfQuestion");
get_data($conn, $sql, $array);

$sql = "select idquestions, questionNumber, questionContent, type from questions where questions.idassessment = $id order by questionNumber ASC";
$array = array("idquestions", "questionNumber", "questionContent", "type");
get_data($conn, $sql, $array);

$sql = "SELECT questions.questionNumber, choices.content FROM choices
INNER JOIN questions ON choices.idquestions = questions.idquestions
where questions.idassessment = $id
order by questions.questionNumber";
$array = array("questionNumber", "content");
get_data($conn, $sql, $array);

$conn->close();
echo json_encode($response);
?>