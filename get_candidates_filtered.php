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

function find_all_random()
{
		global $con,$institute_id,$matched_random;
		$sql="select * from jobs where institute_id='$institute_id'";
		$result=mysqli_query($con,$sql);
		if(!$result)
			die();
		$matched_random=array();
		while($row=mysqli_fetch_array($result))
		{
			$job_id=$row['job_id'];
			$m_all=find_all_matched($job_id);
			if(count($m_all)>0)
			{
				for($i=0;$i<count($m_all);$i++)
				{
					$ma=$m_all[$i];
					if(!in_array($ma,$matched_random))
					{
						array_push($matched_random,$ma);
						$ma_arr=explode(" ",$ma);
						show_cand($job_id,$ma_arr,"random");
					}
				}
			}
		}
		
	
}
function show_cand($j_id,$m_all,$based)
{
	global $con,$row_job;
	get_job($j_id);
	if($based=="random")
	{
		$based="";
	}
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
	<div class="row" style="margin-top: 20px;padding: 10px;"><div class="col-md-1"></div><div class="col-md-1"><b>Job:</b></div><div class="col-md-4"><?php echo $row_job['job_title']; ?></div></div>
	<div class="row" style="margin: 30px;">
	
		<div class="container" style="margin-top:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;">
		
		<form method="post" action="institute_get_cand.php">
		<div class="row">
		<input type="hidden" name="cand_id" value="<?php echo $cand_id; ?>" />
		<input type="hidden" name="job_id" value="<?php echo $j_id; ?>" />
			<div id="<?php echo $cand_id."".$cand_name; ?>" style="margin: 10px;">
			<div class="media">
				<div class="media-left">
				  <img class="img-circle" style="height:100px;" src="data:image/jpeg;base64,<?php echo $im; ?>" />
				</div>
				<div class="media-body" style="">
				<div class="row">
					<div class="col-lg-6">
						<div class="media-heading"><h5><b><?php echo $cand_name; ?></b></h5></div>
						<div style="margin: 5px;" align="left">
							<?php echo $desc; ?>
						</div>
					</div>
					<div class="col-lg-offset-2 col-lg-4">
						<b>Special skills</b>
						<table class="myTable">
							<?php
									$len=count($qualis);
									for($j=1;$j<=$len;$j++)
									{
										?>
										<tr>
											<td><?php echo $j; ?></td>
											<td><?php echo $qualis[$j-1]; ?></td>
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
		
		</div>
		<div class="row" style="background-color:rgba(23,139,158,1.00);min-height:40px;color:white;">
			<span style="vertical-align:middle;line-height: 50px;"><button type="submit" class="btn btn-info" >View Profile</button></span>
		</div>
		</form>
		</div>
	</div>
	<?php
		}
	}
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

function no_found()
{
	?>
	<div class="row" align="center" style="margin-top: 80px;">
	<div id="no_found"><img src="Images/not-found2.png" width="100px" alt="no found" /></div>
	<br/>
	<div style="color:gray;">Matches(0)</div>
	</div>
	<?php
}
if(isset($_POST['flag']))
{
	$flag=$_POST['flag'];
	if($flag=="random")
	{
		find_all_random();
	}
	else if($flag=="best_match"  && isset($_POST['job_id']))
	{
		$jobid=$_POST['job_id'];
		$m_all=find_all_matched($jobid);
		if(count($m_all)==0)
		{
			no_found();
		}
		else
			show_cand($jobid,$m_all,"Best matches");
	}
	else if($flag=="quali_match"  && isset($_POST['job_id']))
	{
		$jobid=$_POST['job_id'];
		$m_all=find_cand_quali($jobid);
		if(count($m_all)==0)
		{
			no_found();
		}
		else
			show_cand($jobid,$m_all,"'Required skills' based matches");
	}
	else if($flag=="exp_match"  && isset($_POST['job_id']))
	{
		$jobid=$_POST['job_id'];
		$m_all=find_cand_experience($jobid);
		if(count($m_all)==0)
		{
			no_found();
		}
		else
			show_cand($jobid,$m_all,"'Experience' based matches");
	}
	else if($flag=="location_match"  && isset($_POST['job_id']))
	{
		$jobid=$_POST['job_id'];
		$m_all=find_cand_location($jobid);
		if(count($m_all)==0)
		{
			no_found();
		}
		else
			show_cand($jobid,$m_all,"'Location' based matches");
	}
	else if($flag=="no_found")
	{
		no_found();
	}
}
?>