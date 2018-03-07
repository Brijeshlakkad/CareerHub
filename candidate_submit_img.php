<?php
require_once("config.php");
require_once('candidate_details.php');
check_session();
get_details_from_candidate();
require_once("global_links.php");
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
		
		$s="";
        $id=$_SESSION['Userid'];
		date_default_timezone_get("Asia/Kolkata");
        $dataTime = date("Y-m-d H:i:s");
		$im='<img class="img-responsive"  src="Image/noimage.png"/>'; 
		$q1=set_progress('img');
		$q2=set_bits('img');
        $insert = mysqli_query($con,"Update Candidates SET Progress='$q1',Status_bits='$q2',Image='$imgContent',Created='$dataTime' where Email='$id'");
		$sql="Select * from Candidates Where Email='$id'";
        if($insert)
		{
			$result=mysqli_query($con,$sql);
			if($result)
			{
				$row=mysqli_fetch_array($result);
				$im='<img class="img-responsive img-circle" style="height:150px;" src="data:image/jpeg;base64,'.base64_encode($row['Image']).'"/>'; 
				$s="<span style='color:green;'>Profile Picture Set.</span><br/><br/>
				<a class='btn btn-primary' href='candidate_profile.php'>Next</a>";
			}
			else
			{
				$s= "<span style='color:red;'>Profile Picture upload failed.</span>
				 please <a class='btn btn-primary' href='candidate_upload_img.php'>try again</a>";
			}
        }else{
			
           	$s= "<span style='color:red;'>Profile Picture upload failed.</span>
			 please <a class='btn btn-primary' href='candidate_upload_img.php'>try again</a>";
        }
    }else{
        $s= "<span style='color:red;'>Profile Picture upload failed.</span>
			 please <a class='btn btn-primary' href='candidate_upload_img.php'>try again</a>";
    }
?>

<div class="container well login_block" align="center">
	<div class="row center-block ">
		<div><caption><a href="index.php"><a href="index.php"><img src="Images/career-hub-logo.png" class="img-responsive" style="margin-top:10px;width:250px;height:60px;float:center;filter:drop-shadow(0px 0px 3px #ffffff);"/></a></caption></div>
	</div>
	<div class="row">
	<div class="media">
    <div class="media-left">
    </div>
    <div class="media-body">
      <h3 class="media-heading"><?php echo $im; ?><br/><?php echo $s; ?></h3>
    </div>
  	</div>
	</div>
</div>
</body>
</html>