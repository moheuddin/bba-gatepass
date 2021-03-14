<?php
date_default_timezone_set('Asia/Dhaka');
 if(!session_id())
      session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "bbaitstore";
$charset = 'utf8mb4';
$sql = '';
$sql_data = [];
$result = '';
$stmt = '';
$debug='';


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

$method = $_SERVER['REQUEST_METHOD'];
// $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
//$input = json_decode(file_get_contents('php://input'),true);
switch ($method) {
    case 'GET':
        $id = isset($_GET['id']) ? intval($_GET['id']) : '';
        if ($id > 0) {
            $sql = "select * from contacts where id=:id";
            $sql_data = ['id' =>$id];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($sql_data);
            $result = $stmt->fetch();
        } else {
            $sql = "SELECTn * FROM devices ORDER BY device_name ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($sql_data);
            $result = $stmt->fetch();
        }

        break;
    case 'POST':
        $id = isset($_POST['id']) ? intval($_POST['id']) : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        if ($action == 'delete' && $id > 0) {
            // delete record with id = $id
            $sql = "update contacts set disabled = 1, date_updated = NOW() where id = :id";
            $sql_data = ['id' => $id];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($sql_data);
        } else {
            $date = isset($_POST['date']) ? $_POST['date'] : '';
            $time = isset($_POST['time']) ? $_POST['time'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $comments = isset($_POST['comments']) ? $_POST['comments'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $officer = isset($_POST['officer']) ? intval($_POST['officer']) : 0;

            if ($id > 0) {
                // change existing record
                $sql = "update contacts set date = :date, time = :time, description=:description,comments=:comments,  officer=:officer, date_updated = NOW() where id = :id";
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
                $sql = "insert into contacts (date, time, description, comments,  officer, date_created) values (:date, :time, :description, :comments, :officer,  NOW())";
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
	$debug=$_REQUEST;
	$extra = array('isAuthenticate' => $isAuthenticate,'userName' => $userName,'debug' => $debug);
    echo json_encode(array('result'=> $stmt->fetchAll(),'message'=> $extra));
} elseif ($method == 'POST') {
    echo json_encode($stmt->rowCount());
} else {
    echo $stmt->$rowCount();
}
