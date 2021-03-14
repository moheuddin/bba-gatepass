<?php
date_default_timezone_set('Asia/Dhaka');
 if(!session_id())
      session_start();
	  
include "config.php";
$user_id = $_SESSION['userid'];

$charset = 'utf8mb4';
$sql = '';
$sql_data = [];
$result = '';
$stmt = '';
$debug='';

$userName='';


$id = '';
//$con = mysqli_connect($host, $user, $password, $dbname);
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
//var_dump($pdo);exit;

$method = $_SERVER['REQUEST_METHOD'];
// $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
//$input = json_decode(file_get_contents('php://input'),true);
$date = date('Y-m-d');
$debug= $date;

switch ($method) {
    case 'GET':
        $id = isset($_GET['id']) ? intval($_GET['id']) : '';
		$filter = 	(isset($_GET['inactive']) ? '<=' : '>=');
        if ($id > 0) {
            $sql = "select * from contacts where id=:id";
            $sql_data = ['id' =>$id];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($sql_data);
            $result = $stmt->fetch();
        } else {
            $sql = "SELECT *
            FROM
            contacts
            WHERE
                        contacts.`date` >=  '$date' and contacts.is_done = 0 and contacts.user_id=$user_id 
            ORDER BY
            contacts.`date` ASC,
            contacts.`time` ASC";


            $userData = mysqli_query($con,$sql );
          

			
			$extra = array('userName' => $userName,'debug' => $sql);
			  $response = [];
               $mydate=''; 
			  while ($row = mysqli_fetch_assoc($userData)) {
                 $mydate = date('d - m - Y',strtotime(($row['date'])));
                // $mydate = make_bangla_number($mydate);
                 
				array_push($response, [
				  'id'   => $row['id'],
				  'date' => $mydate ,
				  'time' => $row['time'],
				  'visitor_name' => $row['visitor_name'],
				  'designation' => $row['designation'],
				  'mobile' => $row['mobile'],
				  'email' => $row['email'],
				  'comments' => $row['comments']
				]);
			  }
				echo json_encode(array('result'=>$response, 'message'=> $extra));

        }
        

        break;
    case 'POST':
	
        $id = isset($_POST['id']) ? intval($_POST['id']) : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        if ($action == 'delete' && $id > 0) {
            $sql = "DELETE FROM contacts WHERE id=$id";
			if ($con->query($sql) === TRUE) {
			  echo "Record deleted successfully";
			} else {
			  echo "Error deleting record: " . $con->error;
			}

			$con->close();
			
			exit;
			
        }elseif($action=="inactive"){
			
		}
		else {
         
            $date = isset($_POST['date']) ? $_POST['date'] : '';
            $time = isset($_POST['time']) ? $_POST['time'] : '';
            $visitor_name = isset($_POST['visitor_name']) ? $_POST['visitor_name'] : '';
            $visitor_name = isset($_POST['visitor_name']) ? $_POST['visitor_name'] : '';
            $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
            $comments = isset($_POST['comments']) ? $_POST['comments'] : '';
            $user_id=$_SESSION['userid'];

            if ($id > 0) {
                // change existing record
                $sql = "update contacts set date = :date, time = :time, visitor_name=:visitor_name,designation=:designation,email=:email,mobile=:mobile,comments=:comments, date_updated = NOW() where id = :id";
                $sql_data = [
                    'date' => $date,
                    'time' => $time,
                    'visitor_name' => $visitor_name,
                    'designation' => $designation,
                    'email' => $email,
                    'mobile' => $mobile,
                    'comments' => $comments
                ];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($sql_data);
                // $result = $stmt->fetch();

            } else {
                $date = date('Y-m-d H:i:s');

                $sql = 'INSERT INTO contacts (date, time, visitor_name, designation, email,mobile, comments, date_created,user_id) 
                VALUES (?,?,?,?,?,?,?,?,?)'; 
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $date);
                    $stmt->bindParam(2, $time);
                    $stmt->bindParam(3, $visitor_name);
                    $stmt->bindParam(4, $designation);
                    $stmt->bindParam(5, $email);
                    $stmt->bindParam(6, $mobile);
                    $stmt->bindParam(7, $comments);
                    //$stmt->bindParam(8, 1);
                    $stmt->bindParam(8, $date, PDO::PARAM_STR);
                    $stmt->bindParam(9,$user_id, PDO::PARAM_INT);

                    $done = $stmt->execute();

                    if (!$done) {
                    //record not saved to db
                    echo $stmt->errorCode();
                    }else{
                        "Added Successfully.";
                    }

            }
        }
        break;
}

function make_bangla_number( $str ) {
    $engNumber = array(1,2,3,4,5,6,7,8,9,0);
    $bangNumber = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
    $converted = str_replace($engNumber, $bangNumber, $str);
 
    return $converted;
}
function dateFormate($data){
$datetime = strtotime( $data);
return date("d-m-Y", $datetime);

}