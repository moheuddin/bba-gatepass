<?php
date_default_timezone_set('Asia/Dhaka');
if(!session_id())
     session_start();

    if(strlen($_SESSION['alogin'])==0)
    {	
        die();
    }
include "dbconfig.php";

$charset = 'utf8mb4';
$sql = '';
$sql_data = [];
$result = '';
$stmt = '';

$id = '';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
//var_dump($_REQUEST);
$method = $_SERVER['REQUEST_METHOD'];
// $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
//$input = json_decode(file_get_contents('php://input'),true);
$date = date('Y-m-d');
$debug= $date;
$response = [];
switch ($method) {
    case 'GET':
        
		
        if ($id > 0) {
            $sql = "select * from users where user_id=:id";
            $sql_data = ['id' =>$id];
            $stmt =$dbh->prepare($sql);
            $stmt->execute($sql_data);
            $result = $stmt->fetch();
        } else {
            $sql = "select * from users";
            
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    array_push($response, [
                        'user_id'   => $row['user_id'],
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'designation' => $row['designation'],
                        'mobile' => $row['mobile'],
                        'role' => $row['role'],
                        'status' => $row['status']
                    ]);
                }
                echo json_encode(array('result'=>$response, 'message'=> ''));
                                        
        }
			
	
        break;
    case 'POST':
      
       
        if ($action == 'delete' && $id > 0) {
            $sql = "DELETE FROM users WHERE user_id=$id";
            $affectedRows = $dbh->exec($sql);
            echo "Deleted successfully.";
        }
		elseif($action == 'update' && $id>0) {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
            $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
            $role = isset($_POST['role']) ? intval($_POST['role']) : 0;

          
                $sql = "update users set 
                                    name = :name,
                                    designation=:designation,
                                    email=:email,
                                    mobile=:mobile,
                                    status=:status,
                                    role=:role
                                    where user_id = :user_id";

                $sql = $dbh->prepare($sql);
                $sql->bindParam(':name',$name,PDO::PARAM_STR);
                $sql->bindParam(':designation',$designation,PDO::PARAM_STR);
                $sql->bindParam(':email',$email,PDO::PARAM_STR);
                $sql->bindParam(':mobile',$mobile,PDO::PARAM_STR);
                $sql->bindParam(':status',$status,PDO::PARAM_INT);
                $sql->bindParam(':role',$role,PDO::PARAM_INT);
                $sql->bindParam(':user_id',$id,PDO::PARAM_INT);
                
              if($sql->execute()){
                echo "Successfully updated Profile";
                }// End of if profile is ok 
                else{
                print_r($dbh->errorInfo()); // if any error is there it will be posted
                $msg=" Database problem, please contact site admin ";
                }
     

        } elseif($action == 'insert') {
                // add new record
                $sql = "insert into users (name, designation, email, mobile, role,  status) 
                        values (:name, :designation, :email, :mobile, :role,status";
                $sql_data = [
                    'name' => $name,
                    'designation' => $designation,
                    'email' => $email,
                    'mobile' => $mobile,
                    'role' => $role,
                    'status' => $status,
                ];
                $stmt = $dbh->prepare($sql);
                $stmt->execute($sql_data);
                // $result = $stmt->fetch();

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
    $replace_array= array("???", "???", "???", "???", "???", "???", "???", "???", "???", "???");
    $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $bn_number = str_replace($search_array, $replace_array, $number);

    return $bn_number;
}