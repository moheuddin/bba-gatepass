<?php
date_default_timezone_set('Asia/Dhaka');
include "config.php";
$date = date("Y/m/d");

$out = array('error' => false);

$crud = 'read';

if(isset($_GET['crud'])){
	$crud = $_GET['crud'];
}


if($crud == 'read'){
	$sql = "SELECT
	Sum(contacts.is_in) as totalin,
	Sum(contacts.is_out) as totalout
	FROM
	contacts
	WHERE
	contacts.`date` >=  '$date'
	";
	$query = $con->query($sql);
	$members = array();

	while($row = $query->fetch_array()){
		array_push($members, $row);
	}

	$out['members'] = $members;
	
	//not done
	$sql = "SELECT
	count(contacts.is_done) as awaiting
	FROM
	contacts
	WHERE
	contacts.`date` >=  '$date' AND
	contacts.is_in =  0 AND
	contacts.is_out =  0
	";
	$query = $con->query($sql);
	$notdone = array();

	while($row = $query->fetch_array()){
		array_push($notdone, $row);
	}

	$out['notdone'] = $notdone;
}

if($crud == 'create'){

	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];

	$sql = "insert into members (firstname, lastname) values ('$firstname', '$lastname')";
	$query = $con->query($sql);

	if($query){
		$out['message'] = "Member Added Successfully";
	}
	else{
		$out['error'] = true;
		$out['message'] = "Could not add Member";
	}
	
}

if($crud == 'update'){

	$memid = $_POST['memid'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];

	$sql = "update members set firstname='$firstname', lastname='$lastname' where memid='$memid'";
	$query = $con->query($sql);

	if($query){
		$out['message'] = "Member Updated Successfully";
	}
	else{
		$out['error'] = true;
		$out['message'] = "Could not update Member";
	}
	
}

if($crud == 'delete'){

	$memid = $_POST['memid'];

	$sql = "delete from members where memid='$memid'";
	$query = $con->query($sql);

	if($query){
		$out['message'] = "Member Deleted Successfully";
	}
	else{
		$out['error'] = true;
		$out['message'] = "Could not delete Member";
	}
	
}


$con->close();

header("Content-type: application/json");
echo json_encode($out);
die();