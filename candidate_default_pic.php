<?php
require_once("config.php");
require_once('candidate_details.php');
check_session();
get_details_from_candidate();
require_once("global_links.php");
$check = getimagesize("Images/user.png");
    if($check !== false){
        $imgContent = addslashes(file_get_contents("Images/user.png"));

		$s="";
        $id=$_SESSION['Userid'];
		date_default_timezone_get("Asia/Kolkata");
        $dataTime = date("Y-m-d H:i:s");
		$im='<img class="img-responsive"  src="Image/noimage.png"/>';
		$bits[0]=1;
		$sbits=implode(",/,",$bits);
        $insert = mysqli_query($con,"Update Candidates SET Status_bits='$sbits',Image='$imgContent',Created='$dataTime' where Email='$id'");

        if($insert)
		{
			header("location:candidate_profile.php");
        }else{
           	header("location:candidate_upload_img.php");
        }
    }else{
        header("location:candidate_upload_img.php");
    }
?>
