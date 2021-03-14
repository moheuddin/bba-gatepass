<?php
date_default_timezone_set('Asia/Dhaka');
include "dbconfig.php";
$date = date("Y/m/d");

$out = array('error' => false);

$crud = 'read';

if(isset($_GET['crud'])){
	$crud = $_GET['crud'];
}


if($crud == 'read'){
	$sql = "SELECT
	Sum(gatepass.is_in) as totalin,
	Sum(gatepass.is_out) as totalout
	FROM
	gatepass
	WHERE
	gatepass.`date` >=  '$date'
	";
	
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetch();
	$output = array();

	$output['totalin'] = $result['totalin'];
	$output['totalout'] = $result['totalout'];

	
	
	
	//not done
	$sql = "SELECT
	count(gatepass.is_done) as awaiting
	FROM
	gatepass
	WHERE
	gatepass.`date` >=  '$date' AND
	gatepass.is_in =  0 AND
	gatepass.is_out =  0
	";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetch();
	$output['notdone'] = $result['awaiting'];

}

header("Content-type: application/json");
echo json_encode($output);
	
die();