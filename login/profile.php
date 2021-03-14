<?php
session_start();
error_reporting(0);
include('../api/dbconfig.php');

$role =  $_SESSION['role'];
//echo $role ;
//exit;
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../login.php');
}
else{
	
if(isset($_POST['submit']))
  {	
	$file = $_FILES['image']['name'];
	$file_loc = $_FILES['image']['tmp_name'];
	$folder="images/";
	$new_file_name = strtolower($file);
	$final_file=str_replace(' ','-',$new_file_name);
	$final_file=rand(100,1000).$new_file_name;
	
	$name=$_POST['name'];
	$email=$_POST['email'];
	$mobileno=$_POST['mobile'];
	$designation=$_POST['designation'];
	$idedit=$_POST['editid'];
	$image=$_POST['image'];

	if(move_uploaded_file($file_loc,$folder.$final_file))
		{
			$image=$final_file;
			$email = $_SESSION['alogin'];
			$sql = "SELECT * from users where email = (:email);";
			$query = $dbh->prepare($sql);
			$query-> bindParam(':email', $email, PDO::PARAM_STR);
			$query->execute();
			$result=$query->fetch(PDO::FETCH_OBJ);
			if(($result->image!='') && (file_exists("images/".$result->image))){
				unlink("images/".$result->image);
			}
		}

	$sql="UPDATE users SET name=(:name), email=(:email), mobile=(:mobile), designation=(:designation), Image=(:image) WHERE user_id=(:idedit)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':name', $name, PDO::PARAM_STR);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':mobile', $mobileno, PDO::PARAM_STR);
	$query->bindParam(':designation', $designation, PDO::PARAM_STR);
	$query->bindParam(':image', $image, PDO::PARAM_STR);
	$query->bindParam(':idedit', $idedit, PDO::PARAM_STR);
	$result = $query->execute();
	
	$msg="Information Updated Successfully";
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
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #dd3d36;
        color: #fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #5cb85c;
        color: #fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
    </style>


</head>

<body>
    <?php
		$email = $_SESSION['alogin'];
		$sql = "SELECT * from users where email = (:email);";
		$query = $dbh->prepare($sql);
		$query-> bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$result=$query->fetch(PDO::FETCH_OBJ);
		$cnt=1;	
?>
    <?php include('includes/header.php');?>

    <?php 
	if($role =="Administrator"){
		//include('includes/leftbar.php');
	}
	?>
    <div class="content-wrapper" <?php 
		if($role !="Administrator")
		{
			echo ' style="margin-left:0;"';
		}
	?>>


        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><?php echo htmlentities($_SESSION['alogin']); ?></div>
                                <?php if($error){?><div class="errorWrap">
                                    <strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
														else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                                <?php }?>

                                <div class="panel-body">
                                    <form method="post" class="form-horizontal" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <div class="col-sm-4">
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <img src="images/<?php echo htmlentities($result->image);?>"
                                                    style="width:200px; border-radius:50%; margin:10px;">
                                                <input type="file" name="image" class="form-control">
                                                <input type="hidden" name="image" class="form-control"
                                                    value="<?php echo htmlentities($result->image);?>">
                                            </div>
                                            <div class="col-sm-4">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Name<span
                                                    style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="name" class="form-control" required
                                                    value="<?php echo htmlentities($result->name);?>">
                                            </div>

                                            <label class="col-sm-2 control-label">Email<span
                                                    style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="email" class="form-control" required
                                                    value="<?php echo htmlentities($result->email);?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Mobile<span
                                                    style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="mobile" class="form-control" required
                                                    value="<?php echo htmlentities($result->mobile);?>">
                                            </div>

                                            <label class="col-sm-2 control-label">Designation<span
                                                    style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="designation" class="form-control" required
                                                    value="<?php echo htmlentities($result->designation);?>">
                                            </div>
                                        </div>


                                        <input type="hidden" name="editid" class="form-control" required
                                            value="<?php echo htmlentities($result->user_id);?>">

                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <button class="button is-primary" name="submit" type="submit">Save
                                                    Changes</button>
                                            </div>
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

    <style>
    .panel.panel-default {
        margin-top: 20px;
    }
    </style>
</body>

</html>
<?php } ?>