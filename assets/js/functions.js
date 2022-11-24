var questionIndex = [];

function addObjective()
{
    const node = document.getElementById("objectiveQuestion");
    const clone = node.cloneNode(true);
    const collection = clone.children;
    questionIndex.push(clone);
    clone.id = "Q" + questionIndex.length.toString();
    collection[1].innerHTML = "Objective Question" + questionIndex.length.toString() + ":";
    //console.log();
    clone.classList.remove("d-none");
    document.getElementById("assessment").appendChild(clone);
}

function addSubjective()
{
    const node = document.getElementById("subjectiveQuestion");
    const clone = node.cloneNode(true);
    const collection = clone.children;
    questionIndex.push(clone);
    clone.id = "Q" + questionIndex.length.toString();
    collection[1].innerHTML = "Subjective Question" + questionIndex.length.toString() + ":";
    //console.log(questionIndex[questionIndex.length-1]);
    clone.classList.remove("d-none");
    document.getElementById("assessment").appendChild(clone);
}

function removeQuestion(e)
{
    const parent = e.parentElement;
    for(i=0; i<questionIndex.length; i++)
    {
        if(questionIndex[i].id == parent.id)
        {
            questionIndex.splice(i, 1);
            break;
        }
    }
    parent.remove();

    for(i=0; i<questionIndex.length; i++)
    {
        const lable = questionIndex[i].children[1];

        questionIndex[i].id = "Q" + (i+1).toString();

        if(questionIndex[i].getAttribute("name") == "objective")
        {
            lable.innerHTML = "Objective Question" + (i+1).toString() + ":";
            //console.log(questionIndex[i].id);
        }
        else if(questionIndex[i].getAttribute("name") == "subjective")
        {
            lable.innerHTML = "Subjective Question" + (i+1).toString() + ":";
            //console.log(questionIndex[i].id);
        }
        else
        {
            console.log(questionIndex[i].getAttribute("name"));
            console.log("Error removing question.");
        }
    }
}

function addChoice(e)
{
    const node = e.parentElement.lastElementChild;
    const clone = node.cloneNode(true);
    e.parentElement.appendChild(clone);
}

function removeChoice(e)
{
    const parent = e.parentElement;
    var choiceCount = 0;
    for(i=0; i<parent.children.length; i++)
    {
        if(parent.children[i].tagName == "DIV")
        {
            choiceCount++;
        }
    }

    if(choiceCount <= 2)
    {
        return; //do nothing
    }
    else
    {
        parent.lastElementChild.remove();
    }
}

function reloadPage()
{
    window.location.reload();
}

function deleteAssessment(e)
{
    fetch('/sshotel/php/deleteAssessment.php',
    {
        method: 'post',
        body: JSON.stringify(e.value),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    }).then((response) => 
    {
        console.log(response.status);
        return response.json();
    }).then((response) =>
    {
        if(response["Status"] == "OK")
        {
            location.replace("/sshotel/admin/?page=assessment");
        }
        else
        {
            console.log(response["Status"]);
            window.alert("An unexpected error occurred on deleting assessment");
        }
    }).catch((error) => 
    {
        console.log(error);
        modalContent.innerHTML = "An error occured.";
    })
}

function markSubmission(e)
{
    //sessionStorage.setItem('sub-id', e.name);
    //sessionStorage.setItem('ass-id', e.value);
    //window.location.replace('/sshotel/admin/adminMarkAss.php');
    window.location.href="/sshotel/admin/adminMarkAss.php?subID="+e.name;
}

function deleteSubmission(e)
{
    fetch('/sshotel/php/deleteSubmission.php',
    {
        method: 'post',
        body: JSON.stringify(e.name),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    }).then((response) => 
    {
        console.log(response.status);
        return response.json();
    }).then((response) =>
    {
        if(response["Status"] == "OK")
        {
            location.replace("/sshotel/admin/?page=assessment");
        }
        else
        {
            console.log(response["Status"]);
            window.alert("An unexpected error occurred on deleting assessment");
        }
    }).catch((error) => 
    {
        console.log(error);
        modalContent.innerHTML = "An error occured.";
    })
}

function getAssessment(doc)
{
    const assessment_id = sessionStorage.getItem("id");
    
    //console.log(assessment_id);
    name = doc.getElementById("name").value; //console.log(name);
    staff_id = doc.getElementById("staff_id").value; //console.log(staff_id);
    department = doc.getElementById("department").value; //console.log(department);
    date = doc.getElementById("date").value; //console.log(date);

    if(name && staff_id && department && date)
    {
        fetch('php/getAssessment.php',
        {
            method: 'post',
            body: JSON.stringify(assessment_id),
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
            }
        }).then((response) => 
        {
            console.log(response.status);
            return response.json();
        }).then((response) =>
        {
            if(response['response'] == "Error")
            {
                console.log("Error getting available assessments.");
            }
            else if(response['response'] == "OK")
            {
                doc.getElementById("title").innerHTML = response[0][0];
                doc.getElementById("description").innerHTML = response[0][1];

                const table = doc.getElementById("table");
                table.rows[1].cells[0].innerHTML = "Name: " + name;
                table.rows[1].cells[1].innerHTML = "Deparment: " + department;
                table.rows[2].cells[0].innerHTML = "ID Number: " + staff_id;
                table.rows[2].cells[1].innerHTML = "Date: " + date;

                var arry = Object.values(response);
                choices = []; //console.log(arry);
                for(i=0; i<arry.length; i++)
                {
                    if(arry[i].length == 2 && arry[i] != "OK")
                    {
                        choices.push(arry[i]);
                    }
                }
                //console.log(choices);

                //console.log(Object.keys(response).length);
                for(i = 1; i <= response[0][2]; i++)
                {
                    if(response[i][3] == "objective")
                    {
                        node = doc.getElementById("objectiveQuestion");
                        clone = node.cloneNode(true);
                        clone.id = "qid" + response[i][0];
                        clone.children[0].innerHTML = response[i][1] + ") " + response[i][2];
                        doc.getElementById("section").appendChild(clone);

                        for(j = 0; j < choices.length; j++)
                        {
                            //console.log(num + ", " + choices);
                            if(choices[j][0] == response[i][1])
                            {
                                node2 = doc.getElementById("form-check");
                                clone2 = node2.cloneNode(true);
                                clone2.children[0].setAttribute("name", "Q" + response[i][1]);
                                clone2.children[0].setAttribute("value", choices[j][1]);
                                clone2.children[1].innerHTML = choices[j][1];
                                clone.appendChild(clone2);
                            }
                        }
                    }
                    else if(response[i][3] == "subjective")
                    {
                        node = doc.getElementById("subjectiveQuestion");
                        clone = node.cloneNode(true);
                        clone.id = "qid" + response[i][0];
                        clone.children[0].innerHTML = response[i][1] + ") " + response[i][2];
                        doc.getElementById("section").appendChild(clone);
                    }
                    else
                    {
                        console.log("Error loading questions");
                    }
                }

                doc.getElementById("container1").style.display = "none";
                doc.getElementById("container2").style.display = "inherit";
            }
            else
            {
                console.log(response["response"]);
            }
        }).catch((error) => 
        {
            console.log(error);
        })
    }
    else
    {
        window.alert("Invalid form, please try again.");
    }
}

function addAssessment()
{
    const title = document.getElementById('titleInput').value;
    const description = document.getElementById('descriptionInput').value;
    const minScore = document.getElementById('minScoreInput').value;
    const totalScore = document.getElementById('totalScoreInput').value;

    const modalContent = document.getElementById('modalContent');
    const assessment = document.getElementById('assessment');
    
    if(!title || !description || !minScore || !totalScore)
    {
        modalContent.innerHTML = "Submission failed, your fields cannot be empty.";
        return;
    }
    else if(questionIndex == 0)
    {
        modalContent.innerHTML = "Submission failed, there are no question in the assessment.";
        return;
    }

    const questions = [];

    for(i=0; i<questionIndex.length; i++)
    {
        if(!questionIndex[i].children[2].value)
        {
            modalContent.innerHTML = "Submission failed, your questions cannot be empty.";
            return;
        }

        if(questionIndex[i].getAttribute("name") == "objective")
        {
            const choicesArray = [];
            for(j=0; j<questionIndex[i].children.length; j++)
            {
                if(questionIndex[i].children[j].tagName == "DIV")
                {
                    const input = questionIndex[i].children[j].querySelector("input");
                    if(!input.value)
                    {
                        modalContent.innerHTML = "Submission failed, your choices cannot be empty.";
                        return;
                    }
                    choicesArray.push(input.value);
                }
            }
            const obj = {
                questionNumber: (i+1).toString(),
                content: questionIndex[i].children[2].value, 
                type: questionIndex[i].getAttribute("name"),
                choices: choicesArray
            };
            questions.push(obj);
        }
        else if(questionIndex[i].getAttribute("name") == "subjective")
        {
            const obj = {
                questionNumber: (i+1).toString(),
                content: questionIndex[i].children[2].value, 
                type: questionIndex[i].getAttribute("name")
            };
            questions.push(obj);
        }
        else
        {
            modalContent.innerHTML = "Submission failed.";
            console.log("Error in packaging questions.");
            return;
        }
    }

    const data =
    {
        title: title,
        description: description,
        minScore: minScore,
        totalScore: totalScore,
        numberOfQuestions: questionIndex.length,
        questions: questions
    };
    //console.log(JSON.stringify(data));

    fetch('/sshotel/php/storeAssessment.php',
    {
        method: 'post',
        body: JSON.stringify(data),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    }).then((response) => 
    {
        console.log(response.status);
        return response.json();
    }).then((response) =>
    {
        if(response["Status"] == "OK")
        {
            modalContent.innerHTML = "Submission succssful.";
        }
        else
        {
            console.log(response["Status"]);
            modalContent.innerHTML = "Submission failed, error in database.";
        }
    }).catch((error) => 
    {
        console.log(error);
        modalContent.innerHTML = "An error occured.";
    })
}

function submit()
{
    name = document.getElementById("name").value.replace('Name: ', ''); //console.log(name);
    department = document.getElementById("department").value.replace('Department: ', ''); //console.log(department);
    staff_id = document.getElementById("staff_id").value.replace('ID Number: ', ''); //console.log(staff_id);
    date = document.getElementById("date").value.replace('Date: ', ''); //console.log(date);
    answer = [];

    section = document.getElementById("section");
    //console.log(section.children[1]);

    for(i=1; i<section.childElementCount; i++)
    {
        temp = [];
        if(section.children[i].getAttribute("name") == "objective")
        {
            child = section.children[i];
            temp.push(child.id.replace('qid', ''));
            choice = document.querySelector('input[name="Q'+i+'"]:checked');
            if(choice != null)
            {
                temp.push(choice.value);
            }
            else
            {
                temp.push('');
            }
            answer.push(temp);
        }
        else if(section.children[i].getAttribute("name") == "subjective")
        {
            child = section.children[i];
            temp.push(child.id.replace('qid', ''));
            temp.push(child.children[1].value);
            answer.push(temp);
        }
    }
    //console.log(answer);

    const submission =
    {
        assessment_id: assessment_id,
        name: name,
        department: department,
        staff_id: staff_id,
        date: date,
        answers: answer
    };
    //console.log(JSON.stringify(submission));

    fetch('php/submission.php',
    {
        method: 'post',
        body: JSON.stringify(submission),
        headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
        }
    }).then((response) => 
    {
        console.log(response.status);
        return response.json();
    }).then((response) =>
    {
        if(response['Status'] == "Error")
        {
            window.alert("An unexpected error occurred");
        }
        else if(response['Status'] == "OK")
        {
            window.location.replace("assessment.html");
        }
    }).catch((error) => 
    {
        console.log(error);
    })
}

var totalScore = 0;

function calculateScore()
{
    const elements = document.getElementsByClassName('marks');

    for(i=0; i < elements.length; i++)
    {
        totalScore += parseInt(elements[i].value);
    }

    document.getElementById('totalScore').innerHTML = totalScore;
}

function updateScore(id)
{
    //console.log(id);
    const data = {subID: id, score: totalScore};

    fetch('/sshotel/php/updateSubmission.php',
    {
        method: 'post',
        body: JSON.stringify(data),
        headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
        }
    }).then((response) => 
    {
        console.log(response.status);
        return response.json();
    }).then((response) =>
    {
        if(response['Status'] == "Error")
        {
            document.getElementById('modalContent2').innerHTML= "Error submitting.";
        }
        else if(response['Status'] == "OK")
        {
            document.getElementById('modalContent2').innerHTML= "Successfully submitted.";
        }
    }).catch((error) => 
    {
        console.log(error);
    })
}

$(document).ready(function(){
    $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
        sessionStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = sessionStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});