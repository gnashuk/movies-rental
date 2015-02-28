<html>
	<head>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<form class="form-horizontal" name="form" method="post" action="checklogin.php">
      <div style='width: 600px; height: 400px; position: absolute; margin: auto; top: 0; bottom: 0; left: 0; right: 0;'>
  	  	<div class="form-group">
       		<label for="inputEmail3" class="col-sm-2 control-label">Email<font color="red"> *</font></label>
      		<div class="col-sm-10">
        			<input type="email" class="form-control" id="" placeholder="Email">
  	   		</div>
     		</div>
    		<div class="form-group">
		      <label for="inputPassword3" class="col-sm-2 control-label">Password<font color="red"> *</font></label>
      		<div class="col-sm-10">
        			<input type="password" class="form-control" id="inputPassword3" placeholder="Password">
      		</div>
    		</div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Re-type password<font color="red"> *</font></label>
          <div class="col-sm-10">
              <input type="password" class="form-control" id="inputPassword3" placeholder="Re-type password">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Name<font color="red"> *</font></label>
          <div class="col-sm-10">
              <input type="password" class="form-control" id="inputPassword3" placeholder="First name">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Surname<font color="red"> *</font></label>
          <div class="col-sm-10">
              <input type="password" class="form-control" id="inputPassword3" placeholder="Last name">
          </div>
        </div>
        <div class="form-group" align="center">
          <font color="red">*</font> marked fields are required
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
              <label>
                <input type="checkbox"> I have read terms and conditions of <a href="agreement.html">agreement</a>
              </label>
            </div>
          </div>
        </div>
    		<div class="form-group">
       		<div class="col-sm-offset-2 col-sm-10">
        		<button type="submit" class="btn btn-default" name="register">Sign up</button>
      		</div>
  	   	</div>
      </div>
		</form>
	</body>
</html>