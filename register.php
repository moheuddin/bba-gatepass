<?php
 include 'front-header.php';
 ?>
	<div class="login-page bk-img">
		<div class="form-content">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1 class="text-center text-bold form-title">Register</h1>
                        <div class="hr-dashed"></div>
						<div id="form-container" class="well text-center">
                         <form id="registration" method="post" class="form-horizontal" action="api/register.php" enctype="multipart/form-data" >
                            <div class="form-group">
                            <label class="col-sm-1 control-label">Name<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="name" class="form-control" required>
                            </div>
                            <label class="col-sm-1 control-label">Designation<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="designation" class="form-control" required>
                            </div>
                            </div>

                            <div class="form-group">
                           
                            <label class="col-sm-1 control-label">Email<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="email" class="form-control" required>
                            </div>

                            <label class="col-sm-1 control-label">Password<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="password" name="password" class="form-control" id="password" required >
                            </div>

                            </div>

                             <div class="form-group">
                   

                            <label class="col-sm-1 control-label">Phone<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" name="mobileno" class="form-control" required>
                            </div>
                            </div>
                            
                  

								<br>
                                <button class="button is-primary" name="submit" type="submit">REGISTER</button>
                                </form>
                                <br>
                                <br>
								<p>Already Have Account? <a href="login.php" >Signin</a></p>
                            </div>
                            <div class="form-group">
                                <div style="padding:20px;"  id="msg"></div>
                            </div>
						</div>
				</div>
			</div>
		</div>
	</div>
    <?php include 'include/footer-text.php';?>
	<!-- Loading Scripts -->
	<script src="assets/js/jquery-3.5.1.min.js"></script>
    <script>
   $(document).ready( function() { // Wait until document is fully parsed
        $("#registration").on('submit', function(e){
            e.preventDefault();
            var $form = $("#registration");
			var mydata = $form.serialize();
            $.ajax({
            type: 'POST',
            url: $("#registration").attr("action"),
            data: mydata, 
            success: function(response) {
                console.log(response);
                if(response=='exists'){
                        $('#msg').addClass('alert-danger');
                        $('#msg').html('This email/user id already exist. Please choose differentone.');
                    }else if(response=='success'){
						$("#form-container").remove();
						$('#msg').html('Registration Sucessfull! Please ask your Administrator to activate your account.');
						$('#msg').removeClass('alert-danger');
						$("#msg").addClass("alert-success");
                    }else{
						$('#msg').html('Something is wrong!');
					}
                },
            });


        });
    })

    </script>
</body>
</html>