<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome to CareerHub</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/customcss.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/angular.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default navbar-static-top navcust">
<div class="container-fluid">	
		
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" style="margin-top:20px;float:right;background-color:black;" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar" style="background-color:white;"></span>
        <span class="icon-bar" style="background-color:white;"></span>
        <span class="icon-bar" style="background-color:white;"></span>                        
      </button>
		
		<img src="Images/career-hub-logo.png"  width="300" class="img-responsive" style="float:left;filter:drop-shadow(0px 0px 3px #ffffff);" />

    </div>
		
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">	
    	<ul class="nav navbar-nav navbar-right">
      	<li><a href="index.php">Home</a></li>
        <li><a href="">Page 1</a></li>
      	<li><a href="">Page 2</a></li>
        <li><a href="">Page 3</a></li>
        
       	<?php
       	if(!isset($_SESSION['id']))
       	{
       		?>
	<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			<?php
		}
		else
		{ 
			?>
  <li><a href="Profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
	<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>			
			<?php
		  }
	     ?>
    	</ul>
      </div>
</div>	
</nav>
</body>
</html>
