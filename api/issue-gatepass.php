<?php
date_default_timezone_set('Asia/Dhaka');
 if(!session_id())
      session_start();
 
     if(strlen($_SESSION['alogin'])==0)
     {	
         die();
     }
include "dbconfig.php";
$user_id = $_SESSION['userid'];

$charset = 'utf8mb4';
$sql = '';
$sql_data = [];
$result = '';
$stmt = '';
$debug='';

$id = '';
$date = date('Y-m-d');
$response = [];
$action = isset($_REQUEST['action'])?  isset($_REQUEST['action']):'';
$id = isset($_GET['id']) ? intval($_GET['id']) : '';
$filter = 	(isset($_GET['action']) && ($_GET['action']=="active")) ? '>=' : '<=';

//var_dump($_REQUEST);exit;
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        
		
        if ($id > 0) {
            $sql = "select * from gatepass where id=:id";
            $sql_data = ['id' =>$id];
            $stmt = $dbh->prepare($sql);
            $stmt->execute($sql_data);
            $result = $stmt->fetch();
        } else {
            $sql = "SELECT
            gatepass.id,
            gatepass.visitor_name,
            gatepass.address,
            gatepass.`date`,
            gatepass.`time`,
            gatepass.comments,
            gatepass.user_id,
            gatepass.mobile,
            gatepass.email,
            gatepass.designation,
            users.name AS user_name,
            users.designation AS user_designation
            FROM
            gatepass
            Inner Join users ON users.user_id = gatepass.user_id
            WHERE
                        gatepass.`date` $filter  '$date' and gatepass.is_done = 0 and gatepass.user_id=$user_id
            ORDER BY
            gatepass.`date` ASC,
            gatepass.`time` ASC";
             $stmt = $dbh->prepare($sql);
             $stmt->execute();
            //and gatepass.user_id='.$user_id .'    

             while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            
             {
                array_push($response, [
                    'id'   => $row['id'],
                    'date' => dateFormate($row['date']),
                    'time' => $row['time'],
                    'visitor_name' => $row['visitor_name'],
                    'address' => $row['address'],
                    'designation' => $row['designation'],
                    'email' => $row['email'],
                    'mobile' => $row['mobile'],
                    'comments' => $row['comments']
                  ]);
             }
             echo json_encode(array('result'=>$response, 'message'=> 'success', 'user'=>$user_id));

        }
        

        break;
    case 'POST':
        $date = isset($_POST['date']) ? $_POST['date'] : '';
        $time = isset($_POST['time']) ? $_POST['time'] : '';
        $visitor_name = isset($_POST['visitor_name']) ? $_POST['visitor_name'] : '';
        $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
        $comments = isset($_POST['comments']) ? $_POST['comments'] : '';
        $id = isset($_POST['id']) ? intval($_POST['id']) : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $user_id=$_SESSION['userid'];

        //var_dump($_REQUEST);exit;
        if ($action == 'delete' && $id > 0) {
            $sql = "DELETE FROM gatepass WHERE id = ?";        
            $stmt = $dbh->prepare($sql);
        
            $done =  $stmt->execute(array($id));
            if (!$done) {
                $message= $stmt->errorCode();
                }else{
                    $message=  "Deleted Successfully.";
                }
                echo json_encode(array('message'=> $message));
			exit;
			
    
		}elseif($action=='save' && $id>0) {
    
                // change existing record
                $sql = "update gatepass set 
                        date = :date, 
                        time = :time, 
                        visitor_name=:visitor_name,
                        address=:address,
                        designation=:designation,
                        email=:email,
                        mobile=:mobile,
                        comments=:comments, 
                        date_updated = NOW() where id = :id";
                $sql_data = [
                    'date' => $date,
                    'time' => $time,
                    'visitor_name' => $visitor_name,
                    'address' => $address,
                    'designation' => $designation,
                    'email' => $email,
                    'mobile' => $mobile,
                    'comments' => $comments,
                    'id' => $id
                ];
                $stmt = $dbh->prepare($sql);
                $done = $stmt->execute($sql_data);

                if (!$done) {
                $message= $stmt->errorCode();
                }else{
                    $message=  "success";
                }
                echo json_encode(array('message'=> $message));
                exit;

        }elseif($action=='insert') {
                $date = date('Y-m-d H:i:s');
                //var_dump($_REQUEST);exit;
                $sql = 'INSERT INTO gatepass (date, time, visitor_name, address, designation, email,mobile, comments, date_created,user_id) 
                VALUES (?,?,?,?,?,?,?,?,?,?)'; 
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindParam(1, $date, PDO::PARAM_STR);
                    $stmt->bindParam(2, $time, PDO::PARAM_STR);
                    $stmt->bindParam(3, $visitor_name, PDO::PARAM_STR);
                    $stmt->bindParam(4, $address, PDO::PARAM_STR);
                    $stmt->bindParam(5, $designation, PDO::PARAM_STR);
                    $stmt->bindParam(6, $email, PDO::PARAM_STR);
                    $stmt->bindParam(7, $mobile, PDO::PARAM_STR);
                    $stmt->bindParam(8, $comments, PDO::PARAM_STR);
                    //$stmt->bindParam(8, 1);
                    $stmt->bindParam(9, $date, PDO::PARAM_STR);
                    $stmt->bindParam(10,$user_id, PDO::PARAM_INT);

                    $done = $stmt->execute();

                    if (!$done) {
                         $message= $stmt->errorCode();
                    }else{
                        $message=  "success";
                    }
                    echo json_encode(array('message'=> $message));

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