<?php
if(isset($_POST['query']))
{
	$id=$_POST['query'];
	$sql="select * from Candidates where ID='$id'";
	$result=mysqli_query($con,$sql);
	if(!$result)
		die("Server is down.");
	$row=mysqli_fetch_array($result);
	$im=base64_encode($row['Image']);
	$login_name=ucwords($row['Name']);
	$barV=$row['Progress'];
	$qualis=explode(",/,",$row['Quali']);
	$course=$row['Course'];
	$p_year=$row['Passing_year'];
	$intern=$row['Intern'];
	$college=$row["College"];
	$col_pin=$row['College_pincode'];
	
	$postal_add=$row['Postal_Add'];
	$perm_add=$row['Perm_Add'];
	$per_pin=$row['Per_pincode'];
	$dob= date('d/m/Y', strtotime($row['DOB']));
	$gender=$row['Gender'];
}
?>