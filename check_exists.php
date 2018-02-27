<?php
include("config.php");
if(isset($_POST['f']) && isset($_POST['q']))
{
	$f=$_POST['f'];
	$q=$_POST['q'];
	if($f=="s_email")
	{
		$email=$q;
		if($email=="")
		{
				echo "Email is required";
				return;
		}
		else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
				echo "Invalid email";
				return;
		}
		else
		{
					$sql="select * from Candidates where Email='$email'";
					$result=mysqli_query($con,$sql);
					if(!$result)
						die("Error");
					$ro=mysqli_num_rows($result);
					if($ro>0)
					{
						echo "Email already Exists";
						return;
					}
					else
					{
						echo "0";
						return;
					}
		}
	}
	else if($f=="f_email")
	{
					$email=$q;
					$sql="select * from Candidates where Email='$email'";
					$result=mysqli_query($con,$sql);
					if(!$result)
						die("Error");
					$ro=mysqli_num_rows($result);
					if($ro>0)
						echo "0";
					else
						echo "1";
	}
	else if($f=="f_pass" && isset($_POST['f_email']))
	{
					$email=$_POST['f_email'];
					$sql="select * from Candidates where Email='$email'";
					$result=mysqli_query($con,$sql);
					if(!$result)
						die("Error");
					$ro=mysqli_num_rows($result);
					if($ro>0)
						{
							$row=mysqli_fetch_assoc($result);
							if($row['Password']==$q)
								echo "1";
							else
								echo "0";
						}
					else
						echo "1";
					return;
	}
	if($f=="s_bemail")
	{
		$email=$q;
		if($email=="")
		{
				echo "Email is required";
				return;
		}
		else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
				echo "Invalid email";
				return;
		}
		else
		{
			echo "0";
			return;
		}
		
	}
}
mysqli_close($con);
?>