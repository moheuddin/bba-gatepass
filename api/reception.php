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
$debug='';

$method = $_SERVER['REQUEST_METHOD'];
// $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
//$input = json_decode(file_get_contents('php://input'),true);

$date = date('Y-m-d');
$response = [];
$action = isset($_REQUEST['action'])?  isset($_REQUEST['action']):'';
$filter='';
//echo $action;exit;
switch ($method) {
    case 'GET':

        $id = isset($_GET['id']) ? intval($_GET['id']) : '';
        $filter = 	(isset($_GET['action']) && ($_GET['action']=="active")) ? '>=' : '<=';
     

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
            gatepass.date_created,
            gatepass.date_updated,
            gatepass.`date`,
            gatepass.`time`,
            gatepass.is_done,
            gatepass.comments,
            gatepass.updated_by,
            gatepass.user_id,
            gatepass.mobile,
            gatepass.email,
            gatepass.designation,
            gatepass.in_time,
            gatepass.in_date,
            gatepass.reception_comments,
            gatepass.is_in AS is_in,
            gatepass.in_card,
            gatepass.out_card,
            gatepass.is_out,
            gatepass.out_date,
            users.name AS user_name,
            users.designation AS user_designation
            FROM
            gatepass
            Inner Join users ON users.user_id = gatepass.user_id
            WHERE
                        gatepass.`date` $filter  '$date' and gatepass.is_done = 0
            ORDER BY
            gatepass.`date` DESC,
            gatepass.`time` ASC";
             $stmt = $dbh->prepare($sql);
             $stmt->execute();


             while($row = $stmt->fetch(PDO::FETCH_ASSOC))
             {
                array_push($response, [
                    'id'   => $row['id'],
                    'date' => $row['date'],
                    'time' => $row['time'],
                    'visitor_name' => $row['visitor_name'],
                    'address' => $row['address'],
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
             echo json_encode(array('result'=>$response, 'message'=> 'success'));


        }
     
			
	
        break;
    case 'POST':
	
        $id = isset($_POST['id']) ? intval($_POST['id']) : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        if ($action == 'save' && $id > 0) {
           
            //var_dump($_POST);exit;
            $in_time = isset($_POST['in_time']) ? $_POST['in_time'] : '';
            $in_date = isset($_POST['in_date']) ? $_POST['in_date'] : '';
            $out_date = isset($_POST['out_date']) ? $_POST['in_date'] : '';
            $is_in = isset($_POST['is_in']) ? intval($_POST['is_in']) : 0;
            $is_out = isset($_POST['is_out']) ? intval($_POST['is_out']) : 0;
            $in_card = isset($_POST['in_card']) ? $_POST['in_card'] : '';
            $out_card = isset($_POST['out_card']) ? $_POST['out_card'] : '';
            $reception_comments = isset($_POST['reception_comments']) ? $_POST['reception_comments'] : '';
            
            
                $is_done=0;
                if ($is_in ==1 && $is_out == 1){
                    $is_done=1;
                }else{
                    $is_done=0;
                }


              
                    $sql = "update gatepass set 
                                        in_time = :in_time,
                                        in_date=:in_date,
                                        out_date=:out_date,
                                        is_in=:is_in,
                                        is_out=:is_out,
                                        in_card=:in_card,
                                        out_card=:out_card,
                                        reception_comments=:reception_comments,
                                        is_done=:is_done
                                        where id = :id";
    
                    $sql = $dbh->prepare($sql);
                    $sql->bindParam(':in_time',$in_time,PDO::PARAM_STR);
                    $sql->bindParam(':in_date',$in_date,PDO::PARAM_STR);
                    $sql->bindParam(':out_date',$out_date,PDO::PARAM_STR);
                    $sql->bindParam(':is_in',$is_in,PDO::PARAM_INT);
                    $sql->bindParam(':is_out',$is_out,PDO::PARAM_INT);
                    $sql->bindParam(':in_card',$in_card,PDO::PARAM_STR);
                    $sql->bindParam(':out_card',$out_card,PDO::PARAM_STR);
                    $sql->bindParam(':reception_comments',$reception_comments,PDO::PARAM_STR);
                    $sql->bindParam(':is_done',$is_done,PDO::PARAM_INT);
                    $sql->bindParam(':id',$id,PDO::PARAM_INT);
                    
                  if($sql->execute()){
                    echo "Successfully updated Profile";
                    }// End of if profile is ok 
                    else{
                    print_r($dbh->errorInfo()); // if any error is there it will be posted
                    $msg=" Database problem, please contact site admin ";
                    }

        }
        break;
}
