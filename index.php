<?php
include 'front-header.php';
?>
    <div class="container">
      <div id="members" class="card-deck mb-3 text-center">
                   <div id="loader" v-if="isLoaded==false" class="fa-3x">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
      <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="text-center">Visitors Entered Today</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">{{members[0].totalin}}</h1>
            
          </div>
        </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal  text-center">Visitors Visited today</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">{{members[0].totalout}}</h1>
            
          </div>
        </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal text-center">Visitors awaitng for visit</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">{{notdone[0].awaiting}}</h1>
            
          </div>
        </div>
      </div>

     
    </div>
	<?php include 'include/footer-text.php';?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/vue.js"></script>
    <script src="assets/js/axios.min.js"></script>
  
    <script>
     var app = new Vue({
	el: '#members',
	data:{
		showAddModal: false,
		showEditModal: false,
		showDeleteModal: false,
		errorMessage: "",
		successMessage: "",
		members: [],
    notdone:'',
		newMember: {in: '', out: ''},
		clickMember: {},
    is_loaded:false
	},

	mounted: function(){
		this.getAllMembers();
	},

	methods:{
		getAllMembers: function(){
      isLoaded=true;
			axios.get('api/home.php')
				.then(function(response){
					console.log(response);
					if(response.data.error){
						app.errorMessage = response.data.message;

					}
					else{
						app.members = response.data.members;
						app.notdone = response.data.notdone;
            //console.log(app.members );
					}
				});
		},

		saveMember: function(){
			//console.log(app.newMember);
			var memForm = app.toFormData(app.newMember);
			axios.post('api.php?crud=create', memForm)
				.then(function(response){
					//console.log(response);
					app.newMember = {in: '', out:''};
					if(response.data.error){
						app.errorMessage = response.data.message;
					}
					else{
						app.successMessage = response.data.message
						app.getAllMembers();
					}
				});
		},

		updateMember(){
			var memForm = app.toFormData(app.clickMember);
			axios.post('api.php?crud=update', memForm)
				.then(function(response){
					//console.log(response);
					app.clickMember = {};
					if(response.data.error){
						app.errorMessage = response.data.message;
					}
					else{
						app.successMessage = response.data.message
						app.getAllMembers();
					}
				});
		},

		deleteMember(){
			var memForm = app.toFormData(app.clickMember);
			axios.post('api.php?crud=delete', memForm)
				.then(function(response){
					//console.log(response);
					app.clickMember = {};
					if(response.data.error){
						app.errorMessage = response.data.message;
					}
					else{
						app.successMessage = response.data.message
						app.getAllMembers();
					}
				});
		},

		selectMember(member){
			app.clickMember = member;
		},

		toFormData: function(obj){
			var form_data = new FormData();
			for(var key in obj){
				form_data.append(key, obj[key]);
			}
			return form_data;
		},

		clearMessage: function(){
			app.errorMessage = '';
			app.successMessage = '';
		}

	}
});
    </script>
  </body>
</html>
