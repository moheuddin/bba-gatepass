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

$isAuthenticate=true;



$id = '';
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
            $sql = "SELECT
				* from users";
							
        }
			$userData = mysqli_query($con,$sql );


			//$response = array();

			
			$extra = array('isAuthenticate' => $isAuthenticate,'userName' => $userName,'debug' => $debug);
			//echo json_encode(array('result'=>$response, 'message'=> $extra));
			
			 // Create empty array to hold query results
			  $response = [];

			  // Loop through query and push results into $someArray;
			  while ($row = mysqli_fetch_assoc($userData)) {
				 
				array_push($response, [
				  'id'   => $row['id'],
				  'name' => $row['name'],
				  'email' => $row['email'],
				  'designation' => $row['designation'],
				  'mobile' => $row['mobile'],
				  'role' => $row['role'],
				  'status' => $row['status']
				]);
			  }
				echo json_encode(array('result'=>$response, 'message'=> $extra));
			  // Convert the Array to a JSON String and echo it
			  //$someJSON = json_encode($someArray);
			  //echo $someJSON;
		
		//$extra = array('isAuthenticate' => $isAuthenticate,'userName' => $userName,'debug' => $debug);
		//echo json_encode(array('result'=> $stmt->fetch(),'message'=> $extra));
	
        break;
    case 'POST':
	
        $id = isset($_POST['id']) ? intval($_POST['id']) : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        if ($action == 'delete' && $id > 0) {
            $sql = "DELETE FROM users WHERE id=$id";
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
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $comments = isset($_POST['comments']) ? $_POST['comments'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $officer = isset($_POST['officer']) ? intval($_POST['officer']) : 0;

            if ($id > 0) {
                // change existing record
                $sql = "update users set date = :date, time = :time, description=:description,comments=:comments,  officer=:officer, date_updated = NOW() where id = :id";
                $sql_data = [
                    'date' => $date,
                    'time' => $time,
                    'description' => $description,
                    'comments' => $comments,
                    'officer' => $officer,
                    'id' => $id,
                ];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($sql_data);
                // $result = $stmt->fetch();

            } else {
                // add new record
                $sql = "insert into users (date, time, description, comments,  officer, date_created) values (:date, :time, :description, :comments, :officer,  NOW())";
                $sql_data = [
                    'date' => $date,
                    'time' => $time,
                    'description' => $description,
                    'comments' => $comments,
                    'officer' => $officer,
                ];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($sql_data);
                // $result = $stmt->fetch();

            }
        }
        break;
}

if ($method == 'GET') {
	//$debug=$_REQUEST;
		
		//$data = $stmt->fetchAll();
		/*$data = $stmt->fetchAll();
		$json_data=array();//create the array  
		foreach($data as $row)
		{  
		$json_array['id']=$row['id'];  
			$json_array['date']=$row['date'];  
			$json_array['time']=$row['time'];  
			$json_array['description']=$row['description'];  
			$json_array['comments']=$row['comments'];  
			$json_array['officer']=$row['officer'];  
			array_push($json_data,$json_array);  
		} 
		$debug=$json_data;
		*/
		

 
		  
		//echo json_encode(array('result'=> $json_data,'message'=> $extra));
		
	
} elseif ($method == 'POST') {
    //echo json_encode($stmt->rowCount());
} else {
    //echo $stmt->$rowCount();
}
function en2bnNumber ($number){
    $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $bn_number = str_replace($search_array, $replace_array, $number);

    return $bn_number;
}