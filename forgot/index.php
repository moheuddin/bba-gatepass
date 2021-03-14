<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com
*/

?>

<html>
<head>
<title>Password Recover</title>
<link rel='stylesheet' href='../assets/css/bootstrap.min.css' type='text/css' media='all' />
</head>
<body>
<?php
include('../api/dbconfig.php');
if(isset($_POST["email"]) && (!empty($_POST["email"]))){
	$email = $_POST["email"];
	$error="";
if (!$email) {
  	$error .="<p>Invalid email address please type a valid email address!</p>";
	}else{
	$query=$dbh->prepare("SELECT secret FROM users WHERE email=:email");
	$query->bindParam(':email', $email);
	$query->execute();
	
	$result = $query->fetch();
	
	//print_r($result);
	
	if ($result==""){
		$error .= "<h2>No user is registered with this email address!</h2>";
		}
	}
	if($error!=""){
	echo '<div class="container">
			<div class="row vertical-center" style="text-align:center;"
			'.$error.'<br /><a href="javascript:history.go(-1)">Go Back</a>
			</div>	
			
		</div>';

		}else{
	$expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+1, date("Y"));
	$expDate = date("Y-m-d H:i:s",$expFormat);
	$key = md5(2418*2);
	$addKey = substr(md5(uniqid(rand(),1)),3,10);
	$key = $key . $addKey;
// Insert Temp Table
$sql = "update users set secret = :secret, expDate=:expDate where email = :email";
$sql_data = [
	'secret' => $key,
	'expDate' => $expDate,
	'email' => $email
];
$stmt = $dbh->prepare($sql);
$stmt->execute($sql_data);

$output='<p>Dear user,</p>';
$output.='<p>Please click on the following link to reset your password.</p>';
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p><a href="https://eservice.bba.gov.bd/gatepass/forgot/reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">https://eservice.bba.gov.bd/gatepass/forgot/reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';		
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reason.</p>';
$output.='<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your security password as someone may have guessed it.</p>';   	
$output.='<p>Thanks,</p>';
$output.='<p>Bangladesh Bridge Authority ICT Cell</p>';
$body = $output; 
$subject = "Password Recovery - BBA Gatepass System";

$email_to = $email;
$fromserver = "noreply@bbagatepass.com"; 
require("PHPMailer/PHPMailerAutoload.php");
$mail = new PHPMailer();

$mail->IsHTML(true);
$mail->From = "noreply@gatepasssystem.com";
$mail->FromName = "BBA Gatepass System";
$mail->Sender = $fromserver; // indicates ReturnPath header
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email);
if(!$mail->Send()){
echo "Mailer Error: " . $mail->ErrorInfo;
}else{
echo '<div class="container-fluid">
			<div class="row vertical-center" style="text-align: center;
			justify-content: center;">
			<h2>An email has been sent to you with instructions on how to reset your password.</h2>
			</div>
		</div>';
	} 

		}	

}else{
?>
<div class="container-fluid">
      <div class="row vertical-center">
          <form method="post" action="" name="reset" class="col-xs-8 col-xs-offset-2  col-sm-6 col-sm-offset-3 col-md-4 col-sm-offset-4 col-lg-4 col-lg-offset-4">
            <h2>Password Recovery</h2>
            <p>
              <label class="sr-only" for="">Email Address</label>
              <input class="form-control" name="email" type="email" placeholder="Email Address" required autofocus>
            </p>
       
    
            <input class="form-control" type="submit" value="Reset Password"/>
          </form>
      </div>
	</div>

<?php } ?>
<style>
	.vertical-center {
   display: flex;
   align-items: center;
   min-height: 100vh;
}
</style>
</body>
</html>