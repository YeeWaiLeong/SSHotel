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

//for testing purpose
//$json = '{"title":"test","description":"testing","minScore":"65","totalScore":"100","numberOfQuestions":2,
//"questions":[{"questionNumber":"1","content":"wtf","type":"objective","choices":["y","n"]},
//{"questionNumber":"2","content":"why?","type":"subjective"}]}';

//decode json
$data = json_decode($json, true);

if(!$data)
{
    $status["Status"] = "Failed, data is empty";
}
else
{
    $questions = array_slice($data, 5);
    unset($data['questions']);

    $title = $data['title'];
    $description = $data['description'];
    $minimumScore = (int)$data['minScore'];
    $totalScore = (int)$data['totalScore'];
    $numberOfQuestion = (int)$data['numberOfQuestions'];

    $dataInsert = "('".$title."', '".$description."', '".$minimumScore."', '".$totalScore."', '".$numberOfQuestion."')";
    //insert mysql
    $sql = "Insert into assessment (title, description, minimumScore, totalScore, numberOfQuestion)
    values ".$dataInsert;

    if($conn->query($sql) === TRUE)
    {
        $last_id = $conn->insert_id;
        foreach($questions as $qstn)
        {
            foreach($qstn as $val)
            {
                if($val["type"] == "objective")
                {
                    $sql = "Insert into questions (idassessment, questionNumber, questionContent, type)
                    values ('".$last_id."', '".$val['questionNumber']."', '".$val['content']."', '".$val['type']."')";

                    if($conn->query($sql) === true)
                    {
                        $last_question_id = $conn->insert_id;

                        foreach($val["choices"] as $choice)
                        {
                            $sql = "Insert into choices (idquestions, content)
                            values ('".$last_question_id."', '".$choice."')";

                            if($conn->query($sql) === true)
                            {
                                //do nothing
                            }
                            else
                            {
                                $status["Status"] = "Objective question insert failed. $conn->error, $last_id, $last_question_id";
                                break 3;
                            }
                        }
                    }
                }
                else if($val["type"] == "subjective")
                {
                    $sql = "Insert into questions (idassessment, questionNumber, questionContent, type)
                    values ('".$last_id."', '".$val['questionNumber']."', '".$val['content']."', '".$val['type']."')";

                    if($conn->query($sql) === true)
                    {
                        //do nothing
                    }
                    else
                    {
                        $status["Status"] = "subjective question insert failed. $conn->error, $last_id";
                        break 2;
                    }
                }
                else
                {
                    $status["Status"] = "Questions insert failed. $conn->error";
                    break 2;
                }
            }
        }
    }
    else 
    {
        $status["Status"] = "First insert failed. $conn->error";
    }
}

$conn -> close();
echo json_encode($status);
?>