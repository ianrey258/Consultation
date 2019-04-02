<form action="<?= base_url('Signup/register')?>" method="POST">
<div class="register-form">
    <div class="col-md-6">
        <div class="form-group">
             <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username *" value=""value="" required/>
        </div>
        <div class="form-group">
             <label>Firstname</label>
            <input type="text" name="firstname" class="form-control" placeholder="First Name *" value=""value="" required/>
        </div>
        <div class="form-group">
             <label>Middlename</label>
            <input type="text" name="middlename" class="form-control" placeholder="Middle Name *" value=""value="" required/>
        </div>
        <div class="form-group">
             <label>Lastname</label>
            <input type="text" name="lastname" class="form-control" placeholder="Last Name *" value=""value="" required/>
        </div>
        <div class="form-group">
             <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password *" value=""value="" required minlength="6"/>
        </div>
        <div class="form-group">
             <label>Confirm-password</label>
            <input type="password" name="conpassword" class="form-control"  placeholder="Confirm Password *" ata-match-error="Password does'nt match!" placeholder="Confirm Password *" value="" required />
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
             <label>DateOfBirth</label>
            <input type="text" name="dob" class="form-control" id="date" value="2019-12-30" required/>
        </div>
        <div class="form-group gen"value="" required>
             <label>Gender</label><br>
            <input type="radio" name="gender" value="male" checked><span> Male </span> &nbsp;
            <input type="radio" name="gender" value="female"><span> Female </span>          
        </div>
        <div class="form-group">
            <label>Collage</label>
            <select class="form-control" name="college" id="college1"></select>
        </div>
        <div class="form-group">
            <label>Deparment</label>
            <select class="form-control" name="department" id="department1"></select>
        </div>
        <div class="form-group">
             <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Your Email *" value="" value="" required/>
        </div>
        <div class="form-group">
             <label>Phone No.</label>
            <input type="text" name="phonenumber" minlength="10" maxlength="10" name="txtEmpPhone" class="form-control" placeholder="Your Phone *" value="" required/>
        </div>
        <input type="hidden" name="usertype" value="2">
        <input type="submit" class="btnRegister"  value="Register"/>
    </div>
    <div class="col-md-1 minimize" onclick="studentbtnback();">
        <span class="glyphicon glyphicon-chevron-left span1" ></span>
    </div>
</div>
</form>