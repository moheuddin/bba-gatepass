<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
	
if(isset($_POST['submit']))
  {	
	$file = $_FILES['attachment']['name'];
	$file_loc = $_FILES['attachment']['tmp_name'];
	$folder="attachment/";
	$new_file_name = strtolower($file);
	$final_file=str_replace(' ','-',$new_file_name);
	
	$title=$_POST['title'];
    $description=$_POST['description'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
	//$user=$_SESSION['alogin'];
	$name=$_POST['name'];
	$reciver= 'Admin';
    $password=$_POST['password'];
    $designation=$_POST['designation'];
    $attachment=' ';

	if(move_uploaded_file($file_loc,$folder.$final_file))
		{
			$attachment=$final_file;
		}

	
	try {
    	$notireciver = 'Admin';
    $sqlnoti="insert into users (name,email,password,designation,gender,role,mobile) values (:name,:email,:password,:designation,:gender,:role,:mobile)";

    $querynoti = $dbh->prepare($sqlnoti);
	$querynoti->bindParam(':name', $name, PDO::PARAM_STR);
	$querynoti->bindParam(':email', $email, PDO::PARAM_STR);
    $querynoti->bindParam(':password', md5($password), PDO::PARAM_STR);
    $querynoti->bindParam(':designation', $designation, PDO::PARAM_STR);
    $querynoti->bindParam(':gender', $gender, PDO::PARAM_STR);
    $querynoti->bindParam(':role', $role, PDO::PARAM_STR);
    $querynoti->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $querynoti->execute();
	$message="User has been created";
	} catch (PDOException $e) {
		//Do your error handling here
		$message = $e->getMessage();
}

	
	$msg=$message;
}    
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Edit Profile</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">

	<script type= "text/javascript" src="../vendor/countries.js"></script>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.css'>
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="../assets/css/style.css">
	
    <style>
        [v-cloak] { display: none; }
        .table td.edit { cursor: pointer; }
        .table td.edit:hover { text-decoration: underline; }
		@print{
			@page :footer {display: none }
			@page :header {display: none}
		}
		 @media print { 
               .noprint { 
                  display: none; 
               } 
            } 
			@page 
		{
        size:  auto;   /* auto is the initial value */
        margin: 20mm;
		}
		form#mysearchform {
			margin-top: 20px;
			margin-bottom: 20px;
			border: 1px solid #ddd;
		}
		.tabs {
    margin-top: 20px;
}

    </style>
	<style>
	.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
	background: #dd3d36;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
	background: #5cb85c;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>


</head>

<body>
<?php
		$sql = "SELECT * from users;";
		$query = $dbh -> prepare($sql);
		$query->execute();
		$result=$query->fetch(PDO::FETCH_OBJ);
		$cnt=1;	
?>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
                       
							<div class="col-md-12">
                            <h2>Create User</h2>
								<div class="panel panel-default">
									<div class="panel-heading">Create User</div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="user" value="<?php echo htmlentities($result->email); ?>">
											<div class="well row pt-2x pb-3x bk-light">
											 <form method="post" class="form-horizontal" enctype="multipart/form-data" name="regform" onSubmit="return validate();">
												<div class="form-group">
												<label class="control-label">Name<span style="color:red">*</span></label>
												
												<input type="text" name="name" class="form-control" required>
											
												<label class="control-label">Email<span style="color:red">*</span></label>
												
												<input type="text" name="email" class="form-control" required>
												
												</div>

												<div class="form-group">
												<label class="control-label">Password<span style="color:red">*</span></label>
											
												<input type="password" name="password" class="form-control" id="password" required >
												

												<label class="control-label">Designation<span style="color:red">*</span></label>
									
												<input type="text" name="designation" class="form-control" required>
											
												</div>

													
												
												<div class="form-group">
												<label class="control-label">Gender</label>
													<select name="gender" class="form-control" required>
													<option value="">Select</option>
													<option value="Male">Male</option>
													<option value="Female">Female</option>
													</select>
													<label class="control-label">Role<span style="color:red">*</span></label>
													<select name="role" class="form-control" required>
													<option value="">Select</option>
													<option value="1">Admininstrator</option>
													<option value="2">Issuer</option>
													<option value="3">Reception</option>
													</select>
												</div>
												<div class="form-group">
													<label class="control-label">Mobile<span style="color:red">*</span></label>
													
													<input type="number" name="mobile" class="form-control" required>
												</div>
												

												 <div class="form-group">
												<label class="control-label">Avtar</label>
												
											

	
													<input type="file" name="attachment" class="form-control">

												</div>

													<br>
													<button class="btn btn-primary" name="submit" type="submit">Save</button>
													</form>
												</div>
										


</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript">
				 $(document).ready(function () {          
					setTimeout(function() {
						$('.succWrap').slideUp("slow");
					}, 3000);
					});
	</script>
</body>
</html>
<?php } ?>