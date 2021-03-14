<?php
session_start();
include('api/dbconfig.php');

if(isset($_POST['login']))
{
$status=1;
$email=$_POST['username'];
$password=$_POST['password'];
$password = md5($password);
$sql ="SELECT
a.user_id,
a.name,
a.email,
a.`password`,
a.mobile,
a.designation,
a.role,
a.`status`,
b.role AS role
FROM users a
Inner Join role as b ON b.id = a.role WHERE a.email=:email and a.password=:password and a.status=:status";
try
{ 
	$query= $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->bindParam(':status', $status, PDO::PARAM_INT);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	
}
catch(PDOException $e)
{
	//handle_sql_errors($selectQuery, $e->getMessage());
	echo $e->getMessage();
	
}

//var_dump($results);exit;
	if($query->rowCount() > 0)
	//if($query->rowCount() > 0)
	{
		
		$_SESSION['alogin']=$_POST['username'];
		$_SESSION['role']=$results[0]->role;
		$_SESSION['userdesignation']=$results[0]->designation;
		$_SESSION['userid']=$results[0]->user_id;

		if($results[0]->role=="Administrator"){
		echo "<script type='text/javascript'> document.location = 'login/profile.php'; </script>";
		}
		elseif($results[0]->role=="Pass Issuer"){
			echo "<script type='text/javascript'> document.location = 'gatepass.php'; </script>";
		} 
		elseif($results[0]->role=="Reception"){
			echo "<script type='text/javascript'> document.location = 'reception.php'; </script>";
		}
		else{
		echo "<script>alert('Invalid Details Or Account Not Confirmed');</script>";
		}

	}
}
 include 'front-header.php';

?>
	<div class="login-page bk-img">
		<div class="form-content">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<h1 class="text-center text-bold form-title">Login</h1>
						<div class="well row ">
							<div>
								<form method="post">
								<div class="form-group">
									<label for="" class="text-uppercase text-sm">Your Email</label>
									<input type="text" placeholder="Username" name="username" class="form-control mb" required>
</div>
<div class="form-group">
									<label for="" class="text-uppercase text-sm">Password</label>
									<input type="password" placeholder="Password" name="password" class="form-control mb" required>
</div>
									<div class="form-group">
									<button style="margin-top:20px;" class="button is-primary" name="login" type="submit">LOGIN</button>
</div>
								</form>
								<br>
								<p>Don't Have an Account? <a href="register.php" >Signup</a></p>
								<p>Forgot Password? <a href="forgot" >Forgot</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include 'include/footer-text.php';?>
</body>

</html>