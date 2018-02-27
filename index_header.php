<?php
require_once('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome to CareerHub</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/customcss.css" rel="stylesheet">
	<link href="css/search.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/angular.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body scroll="yes" style="overflow: hidden">

<nav class="navbar navbar-default navbar-static-top navcust myBar">
<div class="container-fluid">	
		
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" style="margin-top:25px;float:right;background-color:black;" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar" style="background-color:white;"></span>
        <span class="icon-bar" style="background-color:white;"></span>
        <span class="icon-bar" style="background-color:white;"></span>    
      </button>
		
    <a href="index.php"><img src="Images/career-hub-logo.png" class="img-responsive" style="margin-bottom: 5px; margin-top:5px;width:250px;height:60px;float:left;filter:drop-shadow(0px 0px 3px #ffffff);"/></a>

    </div>
		
  
    <div class="collapse navbar-collapse" id="myNavbar">	
    	<ul class="nav navbar-nav navbar-right">
      	
       
       	<?php
       	if(isset($_SESSION['Userid']))
       	{
       		?>
       	<li>
			  <div class="box" style="padding-top: 10px;">
				  <div class="container-1">
					  <span class="icon"><i class="fa fa-search"></i></span>
					  <input type="search" id="search" placeholder="Search..." />
				  </div>
				</div>
       	</li>
       	<li><a href="institute_profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
       	<li><a href=""><span class="glyphicon glyphicon-map-marker"></span> Find Work!</a></li>
        <li><a href="about_us.php"><span class="glyphicon glyphicon-blackboard"></span> About Us</a></li>
		<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>	
			<?php
		}
		else if(isset($_SESSION['BUserid']))
       	{
       		?>
       	<li>
		  
       	</li>
       	<li><a href="candidate_profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
      	<li><a href=""><span class="glyphicon glyphicon-check"></span> Hire candidate!</a></li>
        <li><a href="about_us.php"><span class="glyphicon glyphicon-blackboard"></span> About Us</a></li>
		<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>	
			<?php
		}
		else
		{ 
			?>
			<li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			<li><a href=""><span class="glyphicon glyphicon-map-marker"></span> Find Work!</a></li>
			<li><a href=""><span class="glyphicon glyphicon-check"></span> Hire candidate!</a></li>
			<li><a href=""><span class="glyphicon glyphicon-blackboard"></span> About Us</a></li>
			<li><a href="candidate.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			<?php
		  }
	     ?>
    	
    	</ul>
      </div>
</div>	
</nav>
