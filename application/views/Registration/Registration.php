<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration</title>
    <link rel="stylesheet" href="<?= base_url();?>assets/jqueryui/jquery-ui.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/jqueryui/jquery-ui.theme.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/bootstrap/css/bootstrap.min.css">  
    <link rel="stylesheet" href="<?= base_url();?>assets/fontawesome/css/all.css">  
	<link rel="stylesheet" href="<?= base_url();?>assets/css/registration.css">
</head>
<body> 
    <div class="container">
        <div id="erroralert" class="alert-danger"><?php echo validation_errors();?></div>
        <div id="selection">   
            <h1 id="head" >User Type</h1>
            <div class="imgstudent"><button type="button" class="btn btn-primary btns1" onclick="studentbtn();">Student</button></div>
            <div class="imgstaff"><button type="button" class="btn btn-success btns2" onclick="facultybtn();">Faculty Staff</button></div>
       </div>
        <div id="register-right">
            <?php $this->load->view('Registration/RegFaculty')?>
        </div>
        <div id="register-left">
            <?php $this->load->view('Registration/RegStudent')?>
           </div>
        </div>  
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
    <script src="<?= base_url();?>assets/jqueryui/jquery-ui.min.js"></script>
    <script src="<?= base_url();?>assets/js/script.js"></script>
</body>
</html>