<?php
include("a_lock.php");
include("../config.php");

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
		
		
        $id=$_SESSION['event_id'];
		date_default_timezone_get("asia,kolkata");
        $dataTime = date("Y-m-d H:i:s");
		
        $insert = mysqli_query($con,"Update events SET Image='$imgContent',Created='$dataTime' where ID='$id'");
        if($insert){
            $s="File uploaded successfully.<br><a href='upload_event.php'>want to add one more event?</a>";
        }else{
           	$s= "File upload failed, please try again.";
        } 
    }else{
        $s="Please select an image file to upload.";
    }
?>
<!DOCTYPE html>
<html>
<head>
<script src="../js/jQuery.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/brij.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div> 
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
		    <li><a href="index.php" style="text-transform:uppercase;">Admin Login</a></li>
		    <li class="active"><a href="upload_event.php">Upload Event</a></li>
			<li><a href="show_all_events.php">Events</a></li>
			<li> <a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container padded" style="line-height: 40px;">
	<h3><?php echo $s; ?></h3>
</div>
</body>
</html>