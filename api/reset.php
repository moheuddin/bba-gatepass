<?php

if (!empty($_POST))
{
	include('../api/dbconfig.php');
	$error='';
	$message='';
	$hasError='';
	$pass1 = isset($_POST["pass1"])? $_POST["pass1"]:'' ;
	$pass2 = isset($_POST["pass2"])? $_POST["pass2"]:'' ;
	
	$email =  isset($_POST["email"]) ? $_POST["email"]:'';
	$curDate = date("Y-m-d H:i:s");
	//$error = var_dump($_POST);
	if($pass1=='' || $pass2==''){
		$error = 'Reset Password and confirm password is blank.';
		$hasError=true;
	}

	if ($pass1!=$pass2){
			$error .= "Password do not match, both password should be same.";
			$hasError=true;
	}

	if($error==""){
			
			$pass1 = md5($pass1);
			$sql = "update users set password = :password, secret=:secret where email = :email";
			$sql_data = [
				'password' => $pass1,
				'secret' => null,
				'email' => $email
			];
			
			$stmt = $dbh->prepare($sql);
			$stmt->execute($sql_data);
			$updateCount = $stmt->rowCount();
			if($updateCount>0){
				$message='<p>Congratulations! Your password has been updated successfully.</p>
				<p><a href="https://eservice.bba.gov.bd/gatepass/login.php">Click here</a> to Login.</p></div><br />';
			}else{
				$error .= 'Something is wrong!';
			}
			
	}
	echo json_encode(array('error'=> $error,'message'=> $message, 'hasError'=>$hasError));
}