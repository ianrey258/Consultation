<form action="<?= base_url('Signup/register')?>" method="POST">
    <span><?echo validation_errors();?></span>
    <?echo form_open('form'); ?>
    <div class="register-form a">
    <div class="col-md-1 minimize" onclick="facultybtnback();">
        <span class="glyphicon glyphicon-chevron-right span" ></span>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username *" value="" required/>
        </div>
        <div class="form-group">
            <label>Firstname</label>
            <input type="text" name="firstname" class="form-control" placeholder="First Name *" value="" required/>
        </div>
        <div class="form-group">
            <label>Middlename</label>
            <input type="text" name="middlename" class="form-control" placeholder="Middle Name *" value="" required/>
        </div>
        <div class="form-group">
            <label>Lastname</label>
            <input type="text" name="lastname" class="form-control" placeholder="Last Name *" value="" required/>
        </div>
        <div class="form-group gend" data-placement="left">
            <label>Gender</label><br>
            <input type="radio" name="gender" value="male" checked><span> Male </span><br>
            <input type="radio" name="gender" value="female"><span>Female </span>          
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" id="pass" class="form-control" placeholder="Password *" value="" required minlength="6"/>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="conpassword" class="form-control" placeholder="Confirm Password *" value="" required/>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" placeholder="Your Email *" value="" required/>
        </div>
        <div class="form-group">
            <label>Collage</label>
            <select class="form-control" name="college" id="college"></select>
        </div>
        <div class="form-group">
            <label>Deparment</label>
            <select class="form-control" name="department" id="department"></select>
        </div>
            <input type="hidden" name="usertype" value="1">
        <input type="submit" class="btnRegister" value="Register"/>
    </div>
    </div>
</div>
</form>
