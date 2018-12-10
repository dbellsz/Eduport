<html>

<head>
	<title></title>
</head>
	
<body>

    <p class="h4 mb-4">Register</p>
<form method="POST" action="signup.php">
   <div>
        <div class="col">
            <!-- First name -->
            <input type="text" id="defaultRegisterFormFirstName" class="form-control" name="fullname" placeholder="Full Name" required>
        </div>
        <div class="col">
            <!-- Roll id -->
            <input type="text" id="defaultRegisterFormLastName" class="form-control" name="rollid" placeholder="Student Roll" maxlength="5" autocomplete="off" required>
        </div>
    </div>

    <!-- E-mail -->
    <input type="email" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="Email Address" name="email" required>

    <!-- Password -->
    <input type="password" id="defaultRegisterFormPassword" class="form-control" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="Password" required>
    <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
        1 Upper case, 1 Lower case and at least 8 characters and 1 digit
    </small>

       <input type="password" id="defaultRegisterFormPassword" class="form-control" placeholder="Re-enter Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="RPassword" required>
    <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
        Must be the same as above
    </small>

      <!-- Default inline 1-->
			<div class="custom-control custom-radio custom-control-inline">
			  <input type="radio" class="custom-control-input" value="male" id="defaultInline1" name="gender">
			  <label class="custom-control-label" for="defaultInline1">Male</label>
			</div>

			<!-- Default inline 2-->
			<div class="custom-control custom-radio custom-control-inline">
			  <input type="radio" class="custom-control-input" value="female" id="defaultInline2" name="gender">
			  <label class="custom-control-label" for="defaultInline2">Female</label>
			</div>

			</br>
	
     

      <div class="form-group">
          <label for="date" class="col-sm-2 control-label">DOB</label>
             <div class="col-sm-10">
             <input type="date"  name="dob" class="form-control" id="date">
             </div>
       </div>
                                                      

    <button class="btn btn-info my-4 btn-block" type="submit" name="submit">Sign up</button>

     <!-- Terms of service -->
    <p>By clicking
        <em>Sign up</em> you agree to our
        <a href="" target="_blank">terms of service</a> and
        <a href="" target="_blank">terms of service</a>. </p>

</form>
<!-- Default form register -->
</body>
</html>