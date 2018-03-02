<?php
include_once("config.php");
function reset_var()
{
	global $i,$name,$id,$len;
	$i=0;
	$len=0;
	// clear id and name array
	unset($id);
	$id = array();
	unset($name);
	$name = array();
}
if(isset($_POST['flag']))
{
	$flag=$_POST['flag'];
	$sql="select * from Candidates";
	$result=mysqli_query($con,$sql);
	if(!$result)
			echo "<span style='color:red;'>Please, try again, later.</span>";
	echo "";
	if($flag=="all")
	{
		reset_var();
		while($row=mysqli_fetch_array($result))
		{
			$name[$i]=$row["Email"];
			$id[$i]=$row['ID'];
			$i++;
		}
		$len=$i;
		show_cands($len,$id,$name,"All Candidates");
	}
	else if($flag=="wait")
	{
		reset_var();
		while($row=mysqli_fetch_array($result))
		{
			$sbits=$row['Status_bits'];
			$bits=explode(",/,",$sbits);
			if(count($bits)==1)
			{
				$name[$i]=$row["Email"];
				$id[$i]=$row['ID'];
				$i++;
			}
		}
		$len=$i;
		show_cands($len,$id,$name,"Waiting Candidates");
	}
	else if($flag=="appr")
	{
		reset_var();
		while($row=mysqli_fetch_array($result))
		{
			$sbits=$row['Status_bits'];
			$bits=explode(",/,",$sbits);
			if(count($bits)>1 && $bits[1]==1)
			{
				$name[$i]=$row["Email"];
				$id[$i]=$row['ID'];
				$i++;
			}
		}
		$len=$i;
		show_cands($len,$id,$name,"Approved Candidates");
	}
	else if($flag=="decl")
	{
		reset_var();
		while($row=mysqli_fetch_array($result))
		{
			$sbits=$row['Status_bits'];
			$bits=explode(",/,",$sbits);
			if(count($bits)>1 && $bits[1]==0)
			{
				$name[$i]=$row["Email"];
				$id[$i]=$row['ID'];
				$i++;
			}
		}
		$len=$i;
		show_cands($len,$id,$name,"Declined Candidates");
	}
}


function show_cands($c_len,$c_id,$c_name,$title)
{
?>

<div class="row">
<div class="form-group" >
<div class="table-responsive" align="center">
<caption><h3 class="heading"><?php echo $title; ?></h3></caption>
<table border="1" class="candTable table table-striped">
			<tr>
				<th>ID</th>
				<th>Name</th>
			</tr>
<?php
	for($j=0;$j<$c_len;$j++)
	{
		$fid=$c_id[$j]."xxx";
	?>
		
			<tr>
				<td><?php echo $c_id[$j]; ?></td>
				<td><a class="btn btn-link form-control" onClick="get_candidate('<?php echo $c_id[$j]; ?>','<?php echo $fid; ?>')" id="<?php echo $fid; ?>" ><?php echo $c_name[$j]; ?></a>
				</td>
			</tr>
		
		<?php
	}
?>
</table>
</div>
</div>
</div>
<?php
}
?>