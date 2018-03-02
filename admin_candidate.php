<?php
include_once('functions.php');
include_once('index_header.php');

check_session();
$sql="Select * from Candidates";
$result=mysqli_query($con,$sql);
if(!$result)
	die("Server is down.");
?>

<style>

.candTable td,th
	{
		text-align: center;
	}
</style>
<div class="container well" id="show_here">
<div class="row">
<div class="form-group" >
<div class="table-responsive" align="center">
<caption><h3 class="heading">All candidates (Unvarified)</h3></caption>  
<table border="1" class="candTable table table-striped">
			<tr>
				<th>ID</th>
				<th>Name</th>
			</tr>
<?php
while($row=mysqli_fetch_array($result))
{
	$id=$row['ID'];
	$fid=$row['ID']."".$row['Name'];
	$sbits=$row['Status_bits'];
	$bits=explode(",/,",$sbits);
	if(count($bits)>1)
		continue;
	else
	{
		?>
		
			<tr>
				<td><?php echo $id; ?></td>
				<td><a class="btn btn-link form-control" id="<?php echo $fid; ?>" onClick="get_candidate('<?php echo $id; ?>','<?php echo $fid; ?>')"><?php echo ucwords($row['Name']); ?></a>
				</td>
				
			</tr>
		
		<?php
	}
}
?>
</table>
</div>
</div>
</div>
</div>

<script>

function get_candidate(query,fid)
	{
				var im="<img src='Images/loading_spinner.gif' id='"+fid+"x"+"' style='width:25px;hight:25px;'/>";
				var x=new XMLHttpRequest();
				x.onreadystatechange=function()
				{
					if(x.readyState<4)
						{
							$("#"+fid+"").append(im);
						}
					if(x.readyState==4 && x.status==200)
						{
							var data=this.responseText;
							$("#"+fid+"x").hide(); //spinner image will be hidden.
							$("#show_here").empty();
							$("#show_here").html(data);
						}
				};
				x.open("POST","admin_candidate_details.php",true);
				x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				x.send("query="+query);
	}
/*	function handle_cand(cid,flag)
	{
				var x=new XMLHttpRequest();
				x.onreadystatechange=function()
				{
					if(x.readyState==4 && x.status==200)
						{
							var data=this.responseText;
							
						}
				};
				x.open("POST","admin_handle_cand.php",true);
				x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				x.send("cid="+cid+"&flag="+flag);
	}*/
</script>
</body>
</html>