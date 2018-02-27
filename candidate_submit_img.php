<?php
require_once("config.php");
require_once('candidate_details.php');
check_session();
require_once("global_links.php");


    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
		
		$s="";
        $id=$_SESSION['Userid'];
		date_default_timezone_get("asia,kolkata");
        $dataTime = date("Y-m-d H:i:s");
		$im='<img class="img-responsive"  src="Image/noimage.png"/>'; 
		$bits[0]=1;
		$sbits=implode(",/,",$bits);
        $insert = mysqli_query($con,"Update Candidates SET Status_bits='$sbits',Image='$imgContent',Created='$dataTime' where Email='$id'");
        if($insert){
			$im='<img class="img-responsive img-circle" style="height: 150px;" src="data:image/jpeg;base64,'.base64_encode($login_image).'"/>'; 
            $s="<span style='color:green;'>Profile Picture Set.</span><br/><br/>
			<a class='btn btn-primary' href='candidate_profile.php'>Next</a>";
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