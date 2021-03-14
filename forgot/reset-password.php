<html>

<head>
    <title>Reset Password - BBA Gatepass System</title>
    <link rel='stylesheet' href='../assets/css/bootstrap.min.css' type='text/css' media='all' />
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
</head>

<body>

    <?php
include('../api/dbconfig.php');

function myhtml(){

	
}

$error='';

if (isset($_GET["key"]) && isset($_GET["email"])
	&& isset($_GET["action"]) && ($_GET["action"]=="reset")
	&& !isset($_POST["action"])){
		$key = $_GET["key"];
		$email = $_GET["email"];
		$curDate = date("Y-m-d H:i:s");

		//SELECT * FROM `users` WHERE `secret`='".$key."' and `email`='".$email."';"
		$query=$dbh->prepare("SELECT email,expdate,secret FROM users WHERE secret=:secret and email=:email");
		$query->bindParam(':email', $email);
		$query->bindParam(':secret', $key);
		$query->execute();

		$row = $query->fetch();

		
		$expDate= $row['expdate'];
		$email = $row['email'];
			if ($row==""){
				$error .= '<h2>Invalid Link</h2>
				<p>The link is invalid/expired. Either you did not copy the correct link from the email, 
				or you have already used the key in which case it is deactivated.</p>
				<p><a href="https://eservice.bba.gov.bd/gatepass/forgot/">Click here</a> to reset password.</p>';
				}else{
				//$row = mysqli_fetch_assoc($query);
				//$expDate = $row['expDate'];
				
				//echo $email;
				if ($expDate >= $curDate){
					
				?>

				<div class="container-fluid" id="app">
					<div class="row vertical-center">
				
						<form method="post" action="" name="update"
							class="col-xs-8 col-xs-offset-2  col-sm-6 col-sm-offset-3 col-md-4 col-sm-offset-4 col-lg-4 col-lg-offset-4">
							<div id="loader" v-if="isLoaded==false" class="fa-3x">
								<i class="fa fa-spinner fa-spin"></i>
							</div>
							<input type="hidden" name="action" value="update">
							<input type="hidden" name="email" ref="email" value="<?php echo $email;?>" >
							<h2>Password Reset</h2>
							<div class="form-group">
								<label class="sr-only" for="">New Password</label>
								<input class="form-control" type="password" ref="pass1" name="pass1" id="pass1" maxlength="15" required />
							</div>
							<div class="form-group">
								<label><strong>Re-Enter New Password:</strong></label><br />
								<input class="form-control" type="password" ref="pass2" name="pass2" id="pass2" maxlength="15" required />
							</div>
							<div class="form-group">
								<div  v-bind:class="{ 'alert alert-danger': hasError}">{{error}}</div>
								<div v-html="message"></div>
							</div>
							<div class="form-group">
								<input class="form-control" type="button" id="reset" value="Reset Password" @click="resetPassword()" />
							</div>
						

						</form>
					</div>
				</div>

    <?php
				
				}else{
					$error .= "<h2>Link Expired</h2>
					<p>The link is expired. You are trying to use the expired link which as valid only 24 hours (1 days after request).<br /><br /></p>";
				//exit;
				}
			}

} // isset email key validate end

if($error!='' )	{
	echo '<div class="container-fluid text-center" id="app">'.$error.'</div>';
	}

?>
<script src="../assets/js/vue.js"></script>
<script src="../assets/js/axios.min.js"></script>

<script type="text/javascript">

app = new Vue({
    el: '#app',
    components: {
       
    },
    data: {
        isLoaded: true,
        formData: {
            pass1: '',
			pass2: '',
			email:''
		},
		error:'',
		message:'',
		hasError:false
    },
    created: function() {
    },
    mounted: function() {
		this.formData.email = this.$refs.email.value;
    },
    computed: {

    },
   
    methods: {
       
        resetPassword: function() {
            app.ajaxloading=true;
            let formData = new FormData();
            //console.log("date:", this.formData.date, "id:", this.formData.id, " key:", this.formData.index)

            app.isLoaded = false;
            formData.append('email', this.formData.email || '')
            formData.append('action', 'update')
            formData.append('pass1', this.$refs.pass1.value || '')
            formData.append('pass2', this.$refs.pass2.value || '')

            axios({
                    method: 'post',
                    url: '../api/reset.php',
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                })
                .then(function(response) {
                    app.isLoaded=false;
					console.log(response)
					app.error = response.data.error;
					app.hasError = response.data.hasError;
					app.message = response.data.message;
					if(app.message){
						setTimeout(function(){ window.location = "/gatepass/login.php"; },3000);
					}
                   
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
                app.isLoaded = true;
        },
        resetForm: function() {
            this.formData = {};
            this.isEditing = false;
            this.closeModal();

        }
    }
});
</script>
	
	<style>
	#loader{text-align: center;}
    .vertical-center {
        display: flex;
        align-items: center;
        min-height: 100vh;
    }
    </style>

</body>

</html>