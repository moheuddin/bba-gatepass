<?php
session_start();
error_reporting(0);
include('../api/dbconfig.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../login.php');
}
else{
$role =  $_SESSION['role'];
// Code for change password	
if(isset($_POST['submit']))
	{
$password=md5($_POST['password']);
$newpassword=md5($_POST['newpassword']);
$username=$_SESSION['alogin'];
$sql ="SELECT Password FROM users WHERE email=:username and password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update users set password=:newpassword where email=:username";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg="Your Password succesfully changed";
}
else {
$error="Your current password is not valid.";	
}
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


    <title>User Change Password</title>

    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script type="text/javascript">
    function valid() {
        if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
            alert("New Password and Confirm Password Field do not match  !!");
            document.chngpwd.confirmpassword.focus();
            return false;
        }
        return true;
    }
    </script>
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
    <?php include('includes/header.php');?>

    <?php 
	if($role =="Administrator"){
		//include('includes/leftbar.php');
	}
	?>


    <div class="content-wrapper">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="">
                            <div class="panel panel-default">
                                <div class="panel-heading">Change Password</div>
                                <div class="panel-body">
                                    <form method="post" name="chngpwd" class="form-horizontal"
                                        onSubmit="return valid();">


                                        <?php if($error){?><div class="errorWrap">
                                            <strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
											else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Current Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" name="password"
                                                    id="password" required>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">New Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" name="newpassword"
                                                    id="newpassword" required>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Confirm Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" name="confirmpassword"
                                                    id="confirmpassword" required>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>



                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4">

                                                <button class="button is-primary" name="submit" type="submit">Save
                                                    changes</button>
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


    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {
            $('.succWrap').slideUp("slow");
        }, 3000);
    });
    </script>

</body>
<style>
.panel.panel-default {
    margin-top: 20px;
}
</style>

</html>
<?php } ?>