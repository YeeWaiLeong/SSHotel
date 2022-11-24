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

<body>
    <div class="col-lg-12">
	<div class="card card-outline card-primary">
    <section>
        <div style="margin: 15px;margin-top: 30px;">
        <button class="float-right" style="margin-right: 16px;" onclick="window.location.replace('/sshotel/admin/?page=assessment')">Refresh</button>
            <ul class="nav nav-tabs" role="tablist" id="myTab">
                <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1">Add assessment</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-2">Manage assessment</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-3">Mark assessment</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" role="tabpanel" id="tab-1" style="margin-top: 30px;">
                    <div style="margin-bottom: 30px;"><label class="form-label" style="margin-right: 15px;font-weight: bold;">Title:</label><input id="titleInput" type="text" style="width: 300px;"></div>
                    <div style="margin-bottom: 30px;"><label class="form-label" style="margin-right: 15px;display: block;font-weight: bold;">Description:</label><textarea id="descriptionInput" style="width: 70%;height: 150px;" placeholder="(e.g., You are to read the questions carefully before attempting to answer. You must obtain a minimum score of 75 <match the minimum score you enter below> marks to pass this paper. Sila baca soalan dengan teliti sebelum memberikan jawapan. Anda memerlukan 75 markah untuk lulus ujian ini.)"></textarea></div>
                    <div style="margin-bottom: 30px;"><label class="form-label" style="margin-right: 15px;font-weight: bold;">Minimum Score:</label><input id="minScoreInput" type="number" style="width: 100px;"><label class="form-label" style="margin-right: 15px;font-weight: bold;margin-left: 15px;">Total Score:</label><input id="totalScoreInput" type="number" style="width: 100px;"></div>
                    <div id="assessment" style="background: var(--bs-border-color);padding: 20px;margin-top: 30px;">
                        <div class="dropdown d-inline-block" style="width: 25%;">
                            <button class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button" style="background: var(--bs-green);">Add Question</button>
                            <div class="dropdown-menu" style="padding: 10px;"><button onclick="addObjective()" type="button" style="margin-right: 10px;">Objective</button><button onclick="addSubjective()" type="button">Subjective</button></div>
                        </div>
                    </div>
                    <!-- put it outside to not get cloned as child -->
                    <div class="d-none" id="objectiveQuestion" name="objective" style="background: var(--bs-border-color);padding: 20px;padding-bottom: 0px;"><button onclick="removeQuestion(this)" type="button" style="background: var(--bs-red);border-style: none;color: var(--bs-white);"><i class="far fa-minus-square"></i></button><label class="form-label" style="margin-right: 15px;font-weight: bold;margin-left: 15px;">Objective Question:</label><textarea class="d-block" style="width: 100%;height: 100px;" placeholder="The Hotel practice an ________policy? Hotel ini mengamalkan dasar_________?"></textarea><button onclick="addChoice(this)" type="button" style="background: var(--bs-green);border-style: none;color: var(--bs-white);margin-top: 20px;margin-right:20px;"><i style="margin: 5px;margin-left: 0px;" class="fas fa-plus"></i>Add More Choice</button><button onclick="removeChoice(this)" type="button" style="background: var(--bs-red);border-style: none;color: var(--bs-white);margin-top: 20px;"><i style="margin: 5px;margin-left: 0px;" class="fas fa-minus"></i>Remove Choice</button>
                        <div><label class="form-label" style="margin-right: 15px;font-weight: bold;margin-top: 20px;">Choice:</label><input type="text" style="width: 500px;"></div>
                        <div><label class="form-label" style="margin-right: 15px;font-weight: bold;margin-top: 20px;">Choice:</label><input type="text" style="width: 500px;"></div>
                    </div>
                    <div class="d-none" id="subjectiveQuestion" name="subjective" style="background: var(--bs-border-color);padding: 20px;padding-bottom: 0px;"><button onclick="removeQuestion(this)" type="button" style="background: var(--bs-red);border-style: none;color: var(--bs-white);"><i class="far fa-minus-square"></i></button><label class="form-label" style="margin-right: 15px;font-weight: bold;margin-left: 15px;">Subjective Question:</label><textarea class="d-block" style="width: 100%;height: 150px;" placeholder="What is our ‘Brand Promise’? Apakah pesanan jenama Sama-Sama Hotel?  (6 marks) or Name 5 room categories available for guests at the Hotel. Namakan 5 kategori bilik yang sedia ada untuk pelanggan Hotel. (10 marks)"></textarea></div>
                    <!---->
                    <div class="text-center" style="margin: 30px;">
                        <div class="modal fade" role="dialog" tabindex="-1" id="modal-1">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Notice</h4><button onclick="reloadPage()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p id="modalContent">...</p>
                                    </div>
                                    <div class="modal-footer"><button onclick="reloadPage()" class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
                                </div>
                            </div>
                        </div><button onclick="addAssessment()" class="btn btn-primary" type="button" style="margin: 60px;" data-bs-target="#modal-1" data-bs-toggle="modal">Submit</button>
                    </div>
                </div>
                <div class="tab-pane fade" role="tabpanel" id="tab-2">
                    <div class="col-md-12 search-table-col" style="margin: auto;">
                        <div class="form-group pull-right col-lg-4"><input id="search1" type="text" class="search form-control" placeholder="Search by typing here.."></div><span id="counter1" class="counter pull-right"></span>
                        <div class="table-responsive table table-hover table-bordered results">
                            <table class="table table-hover table-bordered">
                                <thead class="bill-header cs">
                                    <tr>
                                        <th id="trs-hd-1" class="col-lg-1">Assessment No.</th>
                                        <th id="trs-hd-2" class="col-lg-2">Title</th>
                                        <th id="trs-hd-4" class="col-lg-4">Description</th>
                                        <th id="trs-hd-5" class="col-lg-2">Minimum Score</th>
                                        <th id="trs-hd-3" class="col-lg-2">Total Score</th>
                                        <th id="trs-hd-21" class="col-lg-2">Number of Question</th>
                                        <th class="table-dark col-lg-2" id="trs-hd-6" style="width: 3%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody name="first">
                                    <tr class="warning no-result">
                                        <td colspan="12"><i class="fa fa-warning"></i>&nbsp; No Result !!!</td>
                                    </tr>
                                    <?php
                                        mysqli_report(MYSQLI_REPORT_OFF);
                                        // Create connection
                                        $conn = new mysqli("localhost", "root", "", "sshotel");
                                        if($conn->connect_error)
                                        {die("Failed to connect to MySQL server");}

                                        $qry = $conn->query("SELECT * FROM assessment");
                                        while($row = $qry->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?php echo $row['idassessment']; ?></td>
                                        <td><?php echo $row['title']; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td><?php echo $row['minimumScore']; ?></td>
                                        <td><?php echo $row['totalScore']; ?></td>
                                        <td><?php echo $row['numberOfQuestion']; ?></td>
                                        <td class="table-active text-center">
                                            <button class="btn btn-danger btn-flat btn-sm" style="margin-top: 12px;margin-bottom: 15px;" type="button" role="button" name="del-id" value='<?php echo $row['idassessment'] ?>' onclick="deleteAssessment(this)"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" role="tabpanel" id="tab-3">
                    <div class="col-md-12 search-table-col" style="margin: auto;">
                        <div class="form-group pull-right col-lg-4"><input id="search2" type="text" class="search form-control" placeholder="Search by typing here.."></div><span id="counter2" class="counter pull-right"></span><div class="table-responsive table table-hover table-bordered results">
                            <table class="table table-hover table-bordered">
                                <thead class="bill-header cs">
                                    <tr>
                                        <th id="trs-hd-12" class="col-lg-1" style="width: 1%;">Submission No.</th>
                                        <th id="trs-hd-13" class="col-lg-2" style="width: 10%;">Assessment Title</th>
                                        <th id="trs-hd-14" class="col-lg-2" style="width: 10%;">Name</th>
                                        <th id="trs-hd-15" class="col-lg-2" style="width: 7%;">ID Number</th>
                                        <th id="trs-hd-16" class="col-lg-2" style="width: 9%;">Department</th>
                                        <th id="trs-hd-18" class="col-lg-2" style="width: 9%;">Date</th>
                                        <th id="trs-hd-19" class="col-lg-2" style="width: 6%;">Mark Status</th>
                                        <th id="trs-hd-20" class="col-lg-2" style="width: 5%;">Score</th>
                                        <th class="table-dark col-lg-2" id="trs-hd-17" style="width: 3%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody name="second">
                                    <tr class="warning no-result">
                                        <td colspan="12"><i class="fa fa-warning"></i>&nbsp; No Result !!!</td>
                                    </tr>
                                    <?php
                                        mysqli_report(MYSQLI_REPORT_OFF);
                                        // Create connection
                                        $conn = new mysqli("localhost", "root", "", "sshotel");
                                        if($conn->connect_error)
                                        {die("Failed to connect to MySQL server");}

                                        $qry = $conn->query("SELECT submission.idassessment, submission.idsubmission, assessment.title, submission.staff_id,
                                        submission.name, submission.department, submission.date, submission.markStatus, submission.score
                                        FROM sshotel.submission INNER JOIN sshotel.assessment
                                        ON submission.idassessment = assessment.idassessment;");
                                        while($row = $qry->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?php echo $row['idsubmission'] ?></td>
                                        <td><?php echo $row['title'] ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['staff_id'] ?></td>
                                        <td><?php echo $row['department'] ?></td>
                                        <td><?php echo $row['date'] ?></td>
                                        <td><?php if($row['markStatus']==0) echo "Not Marked"; else echo "Marked"; ?></td>
                                        <td><?php echo $row['score'] ?></td>
                                        <td class="table-active text-center">
                                        <div class="btn-group" style="margin-top: 12px;margin-bottom: 15px;">
                                        <button name="<?php echo $row['idsubmission'] ?>" value="<?php echo $row['idassessment'] ?>" class="btn btn-primary btn-flat btn-sm" role="button" onclick="markSubmission(this)"><i class="far fa-edit"></i></button>
                                        <button name="<?php echo $row['idsubmission'] ?>" value="<?php echo $row['idassessment'] ?>" class="btn btn-danger btn-flat btn-sm" role="button" onclick="deleteSubmission(this)"><i class="far fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                    </tr>
                                    <?php endwhile; $conn->close(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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