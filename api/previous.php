<?php
date_default_timezone_set('Asia/Dhaka');
 if(!session_id())
      session_start();
	  
include "config.php";

$charset = 'utf8mb4';
$sql = '';
$sql_data = [];
$result = '';
$stmt = '';
$debug='';

$userName='';



// $con = mysqli_connect($host, $user, $password, $dbname);
//var_dump($_POST);exit;
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,

];
try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
//var_dump($pdo);exit;

$method = $_SERVER['REQUEST_METHOD'];
// $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
//$input = json_decode(file_get_contents('php://input'),true);

$date = date('Y-m-d');
$debug= $date;
$action = isset($_REQUEST['action'])?  isset($_REQUEST['action']):'';
//echo $action;exit;
switch ($method) {
    case 'GET':

            $sql = "SELECT
            contacts.id,
            contacts.visitor_name,
            contacts.date_created,
            contacts.date_updated,
            contacts.`date`,
            contacts.`time`,
            contacts.description,
            contacts.is_done,
            contacts.comments,
            contacts.updated_by,
            contacts.user_id,
            contacts.mobile,
            contacts.email,
            contacts.designation,
            contacts.in_time,
            contacts.in_date,
            contacts.reception_comments,
            contacts.is_in AS is_in,
            contacts.in_card,
            contacts.out_card,
            contacts.is_out,
            contacts.out_date,
            users.name AS user_name,
            users.designation AS user_designation
            FROM
            contacts
            Inner Join users ON users.user_id = contacts.user_id
            WHERE
                        contacts.`date` <=  '$date'
            ORDER BY
            contacts.`date` ASC,
            contacts.`time` ASC";

     
			$userData = mysqli_query($con,$sql );


			//$response = array();

			
			$extra = array('userName' => $userName,'debug' => $sql);
			//echo json_encode(array('result'=>$response, 'message'=> $extra));
			
			 // Create empty array to hold query results
			  $response = [];

			  // Loop through query and push results into $someArray;
			  while ($row = mysqli_fetch_assoc($userData)) {
				 
				array_push($response, [
				  'id'   => $row['id'],
				  'date' => $row['date'],
				  'time' => $row['time'],
				  'visitor_name' => $row['visitor_name'],
				  'designation' => $row['designation'],
				  'email' => $row['email'],
				  'in_card' => $row['in_card'],
				  'out_card' => $row['out_card'],
				  'is_in' => $row['is_in'],
				  'is_out' => $row['is_out'],
				  'in_date' => $row['in_date'],
				  'in_time' => $row['in_time'],
				  'out_date' => $row['out_date'],
				  'email' => $row['email'],
				  'mobile' => $row['mobile'],
				  'reception_comments' => $row['reception_comments'],
				  'comments' => $row['comments'],
				  'user_name' => $row['user_name'],
				  'user_designation' => $row['user_designation'],
				  
				]);
			  }
				echo json_encode(array('result'=>$response, 'message'=> $extra));
 
}
