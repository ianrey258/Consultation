<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/bootstrap/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/fontawesome/css/all.css">  
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/login.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/jqueryui/jquery-ui.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/jqueryui/jquery-ui.theme.css">
    <script src="<?= base_url();?>/assets/bootstrap/js/jquery.js"></script>
    <script src="<?= base_url();?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url();?>/assets/js/script.js"></script>
    <script src="<?= base_url();?>assets/jqueryui/jquery-ui.min.js"></script>

</head>
<body class="register">
	<div class="container">
		<div class="col-md-9 register-right">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <h4 align="center">(Consultation System)</h4>
                </ul>
		
<div class="card">
<div class="card-body">
	<h4 class="card-title mb-4 mt-1" align="center">Sign in</h4>
	<hr>
    <div class="alert-danger"><?php echo $errormsg;?></div>
	<div>
	<form action="<?= base_url('Signin/login')?>" method="POST">
    <div class="form-group input-group">
    	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input name="username" class="form-control" placeholder="Username" type="text" required>
    </div> 
    <div class="form-group input-group">
    	<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input name="password" class="form-control" placeholder="******" type="password" required>
    </div>                                     
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Login"/>
            </div> 

          <div class="checkbox">
      <label> <input type="checkbox"> Save password </label>
    </div> 
        </div>
        <div class="col-md-6 text-right">
            <a class="small" href="#">Forgot password?</a>
        </div>    
        <div class="col-md-6 text-right"><a href="<?= base_url('Signin/register');?>" class="medium">Sign up</a></div>                                        
    </div>                                                                   
    </form>
    </div>
</div>
</div>  
</div> 
</body>
</html>