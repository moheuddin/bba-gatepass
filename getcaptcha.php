<?php
session_start();
$status = '';
if ( isset($_POST['captcha']) && ($_POST['captcha']!="") ){
// Validation: Checking entered captcha code with the generated captcha code
if(strcasecmp($_SESSION['captcha'], $_POST['captcha']) != 0){
// Note: the captcha code is compared case insensitively.
// if you want case sensitive match, update the check above to strcmp()
$status = "<p style='color:#FFFFFF; font-size:20px'><span style='background-color:#FF0000;'>Entered captcha code does not match! Kindly try again.</span></p>";
}else{
$status = "<p style='color:#FFFFFF; font-size:20px'><span style='background-color:#46ab4a;'>Your captcha code is match.</span></p>";	
	}
}
?>
<html>
<head>
<title>Demo Create a Simple Captcha Script Using PHP - AllPHPTricks.com</title>
</head>
<body>
<h1>Demo Create a Simple Captcha Script Using PHP</h1>
<?php echo $status; ?>
<form name="form" method="post" action="">
<label><strong>Enter Captcha:</strong></label><br />
<input type="text" name="captcha" />
<p><br /><img src="captcha.php?rand=<?php echo rand(); ?>" id='captcha_image'></p>
<p>Can't read the image? <a href='javascript: refreshCaptcha();'>click here</a> to refresh</p>
<input type="submit" name="submit" value="Submit">
</form>

<br /><br />
<a href="https://www.allphptricks.com/create-a-simple-captcha-script-using-php/">Tutorial Link</a> <br /><br />
For More Web Development Tutorials Visit: <a href="https://www.allphptricks.com/">AllPHPTricks.com</a>
<script>
//Refresh Captcha
function refreshCaptcha(){
    var img = document.images['captcha_image'];
    img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</body>
</html>