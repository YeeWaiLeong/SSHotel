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

<body style="background-image: url(/assets/img/F3.jfif);background-position: right;background-size:auto;">
    <?php require_once('config.php');
      if(isset($_SESSION['msg_status'])){
         $msg_status = $_SESSION['msg_status'];
         unset($_SESSION['msg_status']);
      }
      if($_SERVER['REQUEST_METHOD'] == "POST"){
         $data = '';
         foreach($_POST as $k => $v){
            if(!empty($data)) $data .= " , ";
            $data .= " `{$k}` = '{$v}' ";
         }
         $sql  = "INSERT INTO `messages` set {$data}";
         $save = $conn->query($sql);
         if($save){
            $msg_status = "success";
            foreach($_POST as $k => $v){
               unset($_POST[$k]);
            }
            $_SESSION['msg_status'] = $msg_status;
            header('location:'.$_SERVER['HTTP_REFERER']);
         }else{
            $msg_status = "failed";
            echo "<script>console.log('".$conn->error."')</script>";
            echo "<script>console.log('Query','".$sql."')</script>";
         }
      }
   ?>
    <section id="contact_us" class="m-5">
      <div class="d-flex">
         <div class="col-lg-12">
         <img class="rounded mx-auto d-block" src="/assets/img/SamaSamaHotelLogo1.png" style="margin-bottom: 5px;" width="47" height="47"></img>
            <label class="text-muted text-center mx-auto d-block fs-5" style="margin-bottom: 30px;">Sama.Sama</label>
            <h4 class="fs-2 fw-bold text-center" style="margin-bottom: 30px;"><u>Feedback For Us</u></h4>
            <div class='text-center'>
               <?php if(isset($msg_status) && $msg_status =='success'): ?>
                  <div class="alert alert-success m-5" role="alert">Message Successfully Sent.
                  <a class="btn btn-primary-outline" style="margin-left: 10px;" href="feedback.html"><- Go Back</a>
                  </div>
               <?php elseif(isset($msg_status) && $msg_status =='failed'): ?>
                  <div class="alert alert-danger m-5" role="alert">Message Sending Failed.
                  <a class="btn btn-primary-outline" style="margin-left: 10px;" href="feedback.html"><- Go Back</a>
                  </div>
                  <?php endif; ?>
            </div>
            <form action="" id="" style="width:100%" method="POST">
               <div class="d-flex">
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label for="full_name" class="form-label fw-bold fs-5">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required value="<?php echo isset($_POST['full_name']) ? $_POST['full_name'] : "" ?>">
                     </div>
                     <div class="form-group">
                        <label for="contact_no" class="form-label fw-bold fs-5">ID number</label>
                        <input type="text" class="form-control" id="contact_no" name="contact" required value="<?php echo isset($_POST['contact']) ? $_POST['contact'] : "" ?>">
                     </div>
                     <div class="form-group">
                        <label for="subject" class="form-label fw-bold fs-5">Department</label>
                        <input type="text" class="form-control" id="subject" name="subject" required value="<?php echo isset($_POST['subject']) ? $_POST['subject'] : "" ?>">
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label for="message" class="form-label fw-bold fs-5">Message</label>
                        <textarea name="message" id="message" cols="30" rows="11" class="form-control" required><?php echo isset($_POST['message']) ? $_POST['message'] : "" ?></textarea>
                     </div>
                  </div>
               </div>
               <div class="d-flex justify-content-center" style="margin-top: 30px;">
                    <button class="btn btn-primary">Send Message</button>
               </div>
            </div>
         </form>
      </div>
    </section>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/bs-init.js"></script>
    <script src="/assets/js/bold-and-bright.js"></script>
    <script src="/assets/js/Table-With-Search.js"></script>
</body>

</html>