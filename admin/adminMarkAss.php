<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>sama sama hotel</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="/assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="/assets/css/Add-Another-Button.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="/assets/css/Login-Form-Basic-icons.css">
    <link rel="stylesheet" href="/assets/css/Table-With-Search-search-table.css">
    <link rel="stylesheet" href="/assets/css/Table-With-Search.css">
</head>

<body data-bss-parallax-bg="true" style="background-image: url(/assets/img/S2.jpg);background-position: center;background-size: cover;">
    <div class="container" style="padding: 0px;box-shadow: 1px 1px 3px 1px;padding-top: 100px;margin-top: 30px;margin-bottom: 30px;background-color: whitesmoke;">
        <section>
            <img class="rounded mx-auto d-block" src="/assets/img/SamaSamaHotelLogo1.png" style="margin-bottom: 5px;" width="47" height="47"></img>
            <label class="text-muted text-center mx-auto d-block fs-5" style="margin-bottom: 30px;">Sama.Sama</label>
            <?php
                $subID = "";
                if(isset($_GET['subID'])){$subID = $_GET['subID'];}

                mysqli_report(MYSQLI_REPORT_OFF);
                // Create connection
                $conn = new mysqli("localhost", "root", "", "sshotel");
                if($conn->connect_error)
                {die("Failed to connect to MySQL server");}

                $qry = $conn->query("SELECT idassessment FROM submission WHERE idsubmission = $subID");
                $row = $qry->fetch_assoc();
                $assID = $row['idassessment'];

                $qry = $conn->query("SELECT assessment.title, assessment.description, submission.staff_id, 
                submission.name, submission.department, submission.date
                FROM sshotel.submission INNER JOIN sshotel.assessment
                ON submission.idassessment = assessment.idassessment
                WHERE submission.idassessment = $assID");

                while($row = $qry->fetch_assoc()):
            ?>
            <h1 class="text-center"><?php echo $row['title'] ?></h1>
            <div class="table-responsive" style="width: 70%;margin-right: auto;margin-left: auto;padding: 30px;">
                <table class="table table-bordered">
                    <thead>
                        <tr></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name: <?php echo $row['name'] ?></td>
                            <td>Department: <?php echo $row['department'] ?></td>
                        </tr>
                        <tr>
                            <td>ID Number: <?php echo $row['staff_id'] ?></td>
                            <td>Date: <?php echo $row['date'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="fs-5" style="margin-right: 17%;margin-left: 17%;"><?php echo $row['description'] ?></p>
        </section>
        <?php endwhile; ?>
        <section style="margin-top: 70px;margin-right: 17%;margin-left: 17%;">
            <?php
                $qry = $conn->query("SELECT questions.questionNumber, questions.questionContent, answers.content
                FROM sshotel.questions INNER JOIN sshotel.answers
                ON questions.idquestions = answers.idquestions
                WHERE answers.idassessment = $assID
                ORDER BY questions.questionNumber;");

                while($row = $qry->fetch_assoc()):
            ?>
            <p style="margin-top: 30px;"><?php echo $row['questionNumber']; echo ") "; echo $row['questionContent'] ?></p>
            <p style="font-weight: bold;"><?php echo $row['content'] ?></p>
            <div style="margin-bottom: 16px;">
            <label class="form-label" style="font-style: italic;margin-right: 15px;margin-top: 15px;">Mark:</label>
            <input class="marks" type="number" style="width: 70px;">
            </div>
            <?php endwhile; $conn->close(); ?>
        </section>
        <div style="height: 30px;margin-right: 17%;margin-left: 17%;margin-top: 70px;margin-bottom: 30px;">
        <label class="form-label fs-5" style="font-style: italic;margin-right: 15px;">Total Marks =</label>
        <strong class="fs-5" id="totalScore" style="margin-right: 15px;">&lt;Press button to calculate&gt;</strong>
        <button onclick="calculateScore()" data-bss-hover-animate="pulse" type="button" style="padding: 0px;padding-right: 3px;padding-left: 3px;font-size: 14px;">Calculate</button>
        </div>
        <div class="text-center" style="margin: 60px;">
        <button onclick="updateScore(<?php echo $_GET['subID'] ?>)" class="btn btn-primary" type="button" style="margin: 30px;margin-bottom: 100px;" data-bs-target="#modal-2" data-bs-toggle="modal">Submit</button>
        <a class="btn btn-primary" role="button" style="background: #ffffff80;color: var(--bs-black);border-style: none;margin-bottom: 70px;" href="/sshotel/admin/?page=assessment">Cancel</a>
        </div>
        <div class="text-center" style="margin: 30px;">
            <div class="modal fade" role="dialog" tabindex="-1" id="modal-2">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Notice</h4><button onclick="window.location.replace('/sshotel/admin/?page=assessment')" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="modalContent2">...</p>
                        </div>
                        <div class="modal-footer"><button onclick="window.location.replace('/sshotel/admin/?page=assessment')" class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/bs-init.js"></script>
    <script src="/assets/js/bold-and-bright.js"></script>
    <script src="/assets/js/Table-With-Search.js"></script>
    <script src="/assets/js/functions.js"></script>
</body>

</html>