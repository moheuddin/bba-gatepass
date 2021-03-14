<?php
include_once '../api/dbconfig.php';
require "./vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$status=1;
$email=$_POST['email'];
$password=$_POST['password'];
$password = md5($password);
$sql ="SELECT
a.user_id,
a.name,
a.email,
a.`password`,
a.mobile,
a.designation,
a.image,
a.role,
a.`status`,
b.role AS role
FROM users a
Inner Join role as b ON b.id = a.role WHERE a.email=:email and a.password=:password";
try
{ 
	$query= $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
   // var_dump($results);
	
}
catch(PDOException $e)
{
	//handle_sql_errors($selectQuery, $e->getMessage());
	echo $e->getMessage();
	
}



if($query->rowCount() > 0){
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $id = $row['user_id'];
    $name = $row['name'];
    $password2 = $row['password'];

        $secret_key = "YOUR_SECRET_KEY";
        $issuer_claim = "THE_ISSUER"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 60; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $id,
                "name" => $name,
                "email" => $email
        ));

        http_response_code(200);

        $jwt = JWT::encode($token, $secret_key);
        echo json_encode(
            array(
                "message" => "Successful login.",
                "token" => $jwt,
                "email" => $email,
                "expireAt" => $expire_claim
            ));
    }
    else{

        http_response_code(401);
        echo json_encode(array("message" => "Login failed.", "password" => $password));
    }

?>
