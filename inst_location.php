<?php
// Mocks some db results
include_once("config.php");
$sql="Select location from jobs DISTINCT";
$result=mysqli_query($con,$sql);
if(!$result)
	die();
$i=0;
while($row=mysqli_fetch_array($result))
{
	$data[$i]=$row['location'];
}


$search = (isset($_REQUEST['search'])) ? $_REQUEST['search'] : '';

$results = [];

if (!empty($search)) {
    $search = preg_quote($search, '~');
    $searchResults = preg_grep('~' . $search . '~', $data);

    $suggestions = [];
    $i = 0;
    foreach ($searchResults as $result) {
        $suggestions[$i]['suggestion'] = $result;
        $suggestions[$i]['url'] = "selected.php?selected={$result}";
        $i++;
    }

    if (count($suggestions)) {
        $results = ['results' => $suggestions];
    }
}

echo json_encode($results);