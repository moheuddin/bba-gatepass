<?php
include('dbconfig.php');


    $sql = 'SELECT 1 from users WHERE email = ? LIMIT 1';
   
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $_REQUEST['email'], PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row)
    {
        echo 'exists';
		exit;
    }


$name=$_POST['name'];
$email=$_POST['email'];
$password=md5($_POST['password']);
$mobileno=$_POST['mobileno'];
$designation=$_POST['designation'];


$sql ="INSERT INTO users(name,email, password, mobile, designation,  role, status) VALUES(:name, :email, :password,  :mobileno, :designation,2, 0)";
$query= $dbh->prepare($sql);
$query->bindParam(':name', $name, PDO::PARAM_STR);
$query->bindParam(':email', $email, PDO::PARAM_STR);
$query->bindParam(':password', $password, PDO::PARAM_STR);
//$query-> bindParam(':gender', $gender, PDO::PARAM_STR);
$query-> bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
$query->bindParam(':designation', $designation, PDO::PARAM_STR);
//$query-> bindParam(':image', $image, PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();

if($lastInsertId){
	echo 'success';
}else {
echo "Something went wrong. Please try again";
}

?>