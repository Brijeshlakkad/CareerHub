<!DOCTYPE html>
<html>
<head>
	<title>CareerHub</title>
	<meta name="viewport" content="width=device-width initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="customcss.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>

<body>
	<div class="well container Fonts" style="margin:auto;max-width:600px;margin-top:10px;margin-bottom:10px;">
		<img src="Images/career-hub-logo.png" class="img-responsive" style="width:180px;height:45px;filter:drop-shadow(0px 0px 3px #ffffff);"/>
		
		<br>
		<header style="text-align:center;font-size:24px;color:#ff6600;margin-bottom:5px;"> <b>Sign Up here</b> </header>

		<form action="" method="post">
		
		<div>
		Institute Name:
		<input type="text" class="form-control" name="name" placeholder="Enter name of the institute."/>
		<br>
		</div>
		
		<div>
		Official Email:
		<input type="text" class="form-control" name="email" placeholder="Enter email"/>
		<br>
		</div>

		<div>	
		Password:
		<input type="password" class="form-control" name="pass" placeholder="Enter password"/><br>
		</div>

		<div>	
		Confirm Password:
		<input type="password" class="form-control" name="cpass" placeholder="Enter password again"/><br>
		</div>

		<div>
		Contact Number:
		<input type="text" class="form-control" name="contact" placeholder="Enter contact number(10 digits)"/><br>
		</div>

		<hr style="border-width: 1px;border-color:#ccc;"></hr>
		
		<p style="text-align:center;">
		<input type="submit" class="btn btn-primary"  name="submit" value="Sign Up"/>
		</p>

		</form>
	</div>
</body>