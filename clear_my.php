<?php

include_once("config.php");

$sql="UPDATE Candidates SET Progress='30',Status_bits='1',isUpdated='0',Postal_Add='-99',Perm_Add='-99',Per_Pincode='-99',Gender='-99',Course='-99',College='-99',Passing_year='-99',Intern='-99',College_pincode='-99',Quali='0',Description='-99' where Email='lakkadbrijesh@gmail.com'";

$result=mysqli_query($con,$sql);

if($result)
{
	echo "1";
}
else
{
	echo "0";
}
?>