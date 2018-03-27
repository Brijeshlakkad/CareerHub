<?php
require_once('functions.php');
require_once('institute_functions.php');
check_session(); 
get_details_from_institute();
function get_job($jobid)
{
	global $con,$institute_id,$row_job;
	$sql="select * from jobs where job_id='$jobid' and institute_id='$institute_id'";
	$res=mysqli_query($con,$sql);
	$row_job=mysqli_fetch_array($res);
}

function find_cand_quali($jobid)
{
		global $con,$institute_id,$row_job,$matched_quali;
		get_job($jobid);
		$arr_job_quali=explode(",",$row_job['required_skills']);
		$sql="select * from candidates";
		$res=mysqli_query($con,$sql);
		$str="";
		$t=0;
		while($row=mysqli_fetch_array($res))
		{
			$sbits=$row['Status_bits'];
			$bits=explode(",/,",$sbits);
			if(count($bits)>1 && $bits[1]==1)
			{
				$arr_cand_quali=explode(",/,",$row['Quali']);
				$counter=0;
				for($i=0;$i<count($arr_job_quali);$i++)
				{
					for($j=0;$j<count($arr_cand_quali);$j++)
					{
						$comp1=strtolower($arr_job_quali[$i]);
						$comp2=strtolower($arr_cand_quali[$j]);
						if($comp1==$comp2)
						{
							$counter++;
							break;
						}
					}
				}
				if(count($arr_job_quali)==$counter)
				{
					$matched_quali[$t]=$row['ID'];
					$t++;
				}
			}
		}
	return $matched_quali;
}
function find_cand_experience($jobid)
{
	global $con,$institute_id,$row_job,$matched_exp;
	get_job($jobid);
	$sql="select * from candidates";
	$res=mysqli_query($con,$sql);
	$i=0;
	while($row=mysqli_fetch_array($res))
	{
		$sbits=$row['Status_bits'];
		$bits=explode(",/,",$sbits);
		if(count($bits)>1 && $bits[1]==1)
		{
			$j_exp=$row_job['experience'];
			if(intval($j_exp)==0 || $row['Intern']=='No')
			{
				$matched_exp[$i]=$row['ID'];
				$i++;
			}
			else
			{
				if($row['Experience']==$j_exp)
				{
					$matched_exp[$i]=$row['ID'];
					$i++;
				}
			}
		}
	}
	return $matched_exp;
}
function find_cand_location($jobid)
{
	global $con,$institute_id,$row_job,$matched_location;
	get_job($jobid);
	$sql="select * from candidates";
	$res=mysqli_query($con,$sql);
	$i=0;
	while($row=mysqli_fetch_array($res))
	{
		$sbits=$row['Status_bits'];
		$bits=explode(",/,",$sbits);
		if(count($bits)>1 && $bits[1]==1)
		{
			$j_country=strtolower(trim($row_job['country']));
			$j_state=strtolower(trim($row_job['state']));
			$j_city=strtolower(trim($row_job['city']));
			if($j_country==strtolower(trim($row['Country'])))
			{
				if($j_state==strtolower(trim($row['State'])))
				{
					if($j_city==strtolower(trim($row['City'])))
					{
						$matched_location[$i]=$row['ID'];
						$i++;
					}
				}
			}
		}
	}
	return $matched_location;
}
function find_all_matched($jobid)
{
	global $matched_all;
	$matched_quali=find_cand_quali($jobid);
	$matched_exp=find_cand_experience($jobid);
	$matched_location=find_cand_location($jobid);
	$all=0;
	for($i=0;$i<count($matched_quali);$i++)
		{
			for($j=0;$j<count($matched_exp);$j++)
			{
				for($k=0;$k<count($matched_location);$k++)
				{
					if($matched_quali[$i]==$matched_exp[$j] && $matched_location[$k]==$matched_quali[$i])
					{
						$matched_all[$all]=$matched_quali[$i];
						$all++;
					}
				}
			}
		}
	return $matched_all;
}
function show_cand($m_all)
{
	global $con;
	for($i=0;$i<count($m_all);$i++)
	{
		$sql="select * from candidates where ID='$m_all[$i]'";
		$res=mysqli_query($con,$sql);
		if($res)
		{
			$row=mysqli_fetch_array($res);
			$cand_id=$row['ID'];
			$cand_name=$row['Name'];
			$cand_email=$row['Email'];
			$cand_mno=$row['Phone'];
			$cand_image=$row['Image'];

			$sbit=$row['Status_bits'];
			$bits=explode(",/,",$sbit);

			$barV=$row['Progress'];

			$squali=$row['Quali'];
			$qualis=explode(",/,",$squali);

			$degree=$row['Degree'];
			$course=$row['Course'];
			$p_year=$row['Passing_year'];
			$intern=$row['Intern'];
			$college=$row["College"];
			$col_pin=$row['College_pincode'];
			$exp_year=$row['Experience'];

			$postal_add=$row['Postal_Add'];
			$perm_add=$row['Perm_Add'];
			$per_pin=$row['Per_pincode'];
			$dob= date('d/m/Y', strtotime($row['DOB']));
			$gender=$row['Gender'];
			$country=$row['Country'];
			$state=$row['State'];
			$city=$row['City'];

			$updated=$row['isUpdated'];
			$desc=$row['Description'];
			$im=base64_encode($cand_image);
	?>
	<div class="row" style="margin: 30px;">
		<div class="container" style="margin-top:20px;background-color:white;border-left:3px solid Tomato;border-top:2px solid Tomato;box-shadow: 5px 5px 5px #aaaaaa;">
		<div class="row">
		<form method="post" action="institute_get_cand.php">
		<input type="hidden" name="cand_id" value="<?php echo $cand_id; ?>" />
			<div id="<?php echo $cand_id."".$cand_name; ?>">
			<div class="media">
				<div class="media-left">
				  <img class="img-circle" style="height:100px;" src="data:image/jpeg;base64,<?php echo $im; ?>" />
				</div>
				<div class="media-body" style="">
				<div class="row">
					<div class="col-lg-6">
						<div class="media-heading"><b><h5><?php echo $cand_name; ?></h5></b></div>
						<div style="margin: 5px;" align="left">
							<?php echo $desc; ?>
						</div>
					</div>
					<div class="col-lg-offset-2 col-lg-4">
						<table class="myTable">
							<?php
									$len=count($qualis);
									for($i=1;$i<=$len;$i++)
									{
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $qualis[$i-1]; ?></td>
										</tr>
										<?php
									}
								?>
						</table>
					</div>
				</div>
				</div>
			</div>
			</div>
		</form>
		</div>
		<div class="row" style="background-color:Tomato;min-height:40px;color:white;">
			<button type="submit" class="btn btn-default">View Profile</button>
		</div>
		</div>
	</div>
	<?php
		}
	}
}
if(isset($_POST['flag']) && isset($_POST['job_id']))
{
	$flag=$_POST['flag'];
	$jobid=$_POST['job_id'];
	if($flag=="best_match" )
	{
		$m_all=find_all_matched($jobid);
		show_cand($m_all);
	}
	else if($flag=="quali_match")
	{
		$m_all=find_cand_quali($jobid);
		show_cand($m_all);
	}
	else if($flag=="exp_match")
	{
		$m_all=find_cand_experience($jobid);
		show_cand($m_all);
	}
	else if($flag=="location_match")
	{
		$m_all=find_cand_location($jobid);
		show_cand($m_all);
	}
}
?>