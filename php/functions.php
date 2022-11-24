<?php
function get_data($conn, $sql, $array)
{
    global $response;
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $data = array();
            foreach($array as $value)
            {
                array_push($data, $row[$value]);
            }
            array_push($response, $data);
        }
        $response['response'] = "OK";
    }
    else
    {
        $response['response'] = "No results";
    }
}
?>