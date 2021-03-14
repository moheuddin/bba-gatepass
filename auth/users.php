<?php
date_default_timezone_set('Asia/Dhaka');
 if(!session_id())
      session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "bbaitstor";
$charset = 'utf8mb4';
$sql = '';
$sql_data = [];
$result = '';
$stmt = '';
$debug='';

//$debug = var_dump($_REQUEST);
//exit;
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
            $sql = "select * from deviceuser where id=:id";
            $sql_data = ['id' =>$id];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($sql_data);
            $result = $stmt->fetch();
        } else {
            $sql = "SELECT * FROM deviceuser ORDER BY username ASC";
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

            $username= isset($_POST['username']) ? $_POST['username'] : '';
            $designation = isset($_POST['designation']) ? $_POST['designation'] : '';


            if ($id > 0) {
                // change existing record
                $sql = "update deviceuser set username = :username, designation=:designation, date_updated = NOW() where id = :id";
                $sql_data = [
                    'username' => $username,
                    'designation' => $designation,
                    'id' => $id,
                ];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($sql_data);
                // $result = $stmt->fetch();

            } else {
                // add new record
                $sql = "insert into deviceuser (username,  designation, date_updated ) values (:username, :designation,  NOW())";
                $sql_data = [
                    'username' => $username,
                    'designation' => $designation
                ];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($sql_data);
                if ( false===$stmt ) {
                  echo $stmt->error;
                }
                //$result = $stmt->fetch();

            }
        }
        break;
}

if ($method == 'GET') {
 echo json_encode(array('result'=> $stmt->fetchAll()));
} elseif ($method == 'POST') {
    echo json_encode($stmt->rowCount());
} else {
    echo $stmt->$rowCount();
}
