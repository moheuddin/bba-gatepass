<?php
session_start();
error_reporting(0);
$link='';
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
if((isset($_SESSION['role'])) && ($_SESSION['role']=='Administrator')){
	$link ='<li class=""><a href="../reception.php">Check Pass</a></li>
			<li class=""><a href="../gatepass.php">Gate Pass</a></li>';
}elseif((isset($_SESSION['role'])) && ($_SESSION['role']=='Pass Issuer')){
	$link ='<li class=""><a href="../gatepass.php">Gate Pass</a></li>';
}elseif((isset($_SESSION['role'])) && ($_SESSION['role']=='Reception')){
	$link ='<li class=""><a href="../reception.php">Check Pass</a></li>';
}
?>

<div class="brand clearfix">
<h4 class="pull-left text-white text-uppercase" style="margin:20px 0px 0px 20px"><i class="fa fa-user"></i>&nbsp; <?php echo htmlentities($_SESSION['alogin']);?></h4>
		
		<ul class="ts-profile-nav">
			
			<?php echo $link;?>
			<li class="ts-account">
				<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> <i class="fa fa-user"></i>  Account</a>
				<ul>
					<li><a href="change-password.php"><i class="fa fa-key"></i> &nbsp;Change Password</a></li>
					<li><a href="logout.php"><i class="fa fa-sign-out"></i> &nbsp; Logout</a></li>
					<li><a href="profile.php"><i class="fa fa-user"></i> &nbsp;Profile</a></li>	
					<?php if((isset($_SESSION['role'])) && ($_SESSION['role']=='Administrator')){?>
					<li><a href="usermanage.php"><i class="fa fa-envelope"></i> &nbsp;User Manage</a></li>
					<li><a href="createuser.php"><i class="fa fa-user-plus"></i> &nbsp;Create User</a></li>
					<?php }?>
				</ul>
			</li>
		</ul>
	</div>
