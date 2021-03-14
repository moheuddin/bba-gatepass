<?php
include_once '../api/dbconfig.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: post");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

echo 'test';
$name = '';
$designation = '';
$email = '';
$password = '';

$data = json_decode(file_get_contents("php://input"));
$name = $_POST['name'];
$designation = $_POST['designation'];
$email = $_POST['email'];
$password = $_POST['password'];

$table_name = 'users';

$query = "INSERT INTO " . $table_name . "
                SET name = :name,
                    designation = :designation,
                    email = :email,
                    password = :password";

$stmt = $dbh->prepare($query);

$stmt->bindParam(':name', $name);
$stmt->bindParam(':designation', $designation);
$stmt->bindParam(':email', $email);

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$stmt->bindParam(':password', $password_hash);


if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "User was successfully registered."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "Unable to register the user."));
}
