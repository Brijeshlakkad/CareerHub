<?php 
require_once('institute_functions.php');
require_once('functions.php');
@session_start();
SessionData();

$country=strtolower(protect_anything($_POST['country']));
$state=strtolower(protect_anything($_POST['state']));
$city=strtolower(protect_anything($_POST['city']));
$closing_date=protect_anything($_POST['closing_date']);
$max_age=protect_anything($_POST['max_age']);
$description=protect_anything($_POST['description']);
$experience=protect_anything($_POST['experience']);
if($experience=='null')
{
	$experience=0;
}
$type=protect_anything($_POST['type']);
$title=protect_anything($_POST['title']);
$role=strtolower(protect_anything($_POST['role']));
$vacancy=protect_anything($_POST['vacancy']);
$salary=protect_anything($_POST['salary']);
$category=protect_anything($_POST['category']);
$m=$_POST['qualifications'];
$qualifications=implode(',', $m);

$skills=$_POST['skills'];
$opening_date=date("Y-m-d");


if(isset($_POST['action']) && isset($_POST['updateid']))
{
$updateid=$_POST['updateid'];
$update="UPDATE jobs set `job/training`='$type',`job_title`='$title',`category`='$category',`required_skills`='$skills',`role`='$role',`vacancy`='$vacancy',`qualification`='$qualifications',`experience`='$experience',`country`='$country',`state`='$state',`city`='$city',`closing_date`='$closing_date',`description`='$description',`expected_salary`='$salary',`max_age`='$max_age' where `institute_id`='$institute_id' AND `job_id`='$updateid'";
$q1=mysqli_query($con,$update);
if($q1)
{
	echo "Updated Successfully";
}
else
{
	echo "error";
}

}


else
{

$posted=date("Y-m-d H:i:s");
$last_updated=$posted;

$insert="insert into jobs(`institute_id`,`job/training`,`job_title`,`category`,`required_skills`,`role`,`vacancy`,`qualification`,`experience`,`country`,`state`,`city`,`opening_date`,`closing_date`,`description`,`expected_salary`,`max_age`,`posted`,`last_updated`)values('$institute_id','$type','$title','$category','$skills','$role','$vacancy','$qualifications','$experience','$country','$state','$city','$opening_date','$closing_date','$description','$salary','$max_age','$posted','$last_updated')";
$q=mysqli_query($con,$insert);
if($q)
{
	echo "Posted Successfully";
}
else
{
	echo "error";
}

}
/*
	echo $country.'\n '.$state.'\n '.$city.'\n '.$closing_date.'\n '.$max_age.'\n '.$description.'\n '.$experience.'\n '.$type.'\n '.$title.'\n '.$role.'\n '.$vacancy.'\n '.$salary.'\n '.$qualifications.'\n'.$qualifications.'\n'.$institute_id;
*/
?>