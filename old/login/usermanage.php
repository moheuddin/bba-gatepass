<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

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
	
	<title>User Manage</title>

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
	<link rel="stylesheet" href="../assets/css/style.css">
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
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper" v-cloak id="vue_contacts">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">User Manage</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">List Users</div>
							<div class="panel-body">
							
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										       <th>#</th>
												<th>User Name</th>
												<th>E-mail</th>
												<th>Mobile</th>
												<th>Designation</th>
												<th>User Role</th>
												<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<tr v-for="(contact, index) in contacts" :key="contact.id">
										<td width="150">{{index+1}}</td>
										<td>{{ contact.name }}</td>
										<td>{{ contact.email }}</td>
										<td>{{ contact.mobile }}</td>
										<td>{{ contact.designation }}</td>
										<td>{{ contact.role }}</td>
										
										<td  v-if="isAuthenticate" class="edit ">
											<span class="edit" @click="editContact(contact, index)"><i class="fa fa-edit"></i></span>
											
										</td>
									</tr>
									</tbody>

								</table>
							</div>
						</div>
					</div>
				</div>

			</div>
			  <div class="modal" :class="{ 'is-active': isModalOpen }">
                  <div class="modal-background" @click="closeModal()"></div>
                  <div class="modal-card">
                        <header class="modal-card-head">
                            <p class="modal-card-title">{{ modalTitle }}</p>
                            <button class="delete" aria-label="close" @click="closeModal()"></button>
                        </header>
                        <section class="modal-card-body">
                        <form v-on:submit.prevent>
						    
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input class="input"  class="form-control" type="text" name="name" v-model="formData.name" required>
                            </div>
						
              
                            <div class="form-group">
                                <label class="control-label">Designation</label>
                                <input class="input" class="form-control" type="text" name="designation" v-model="formData.designation">
								
                            </div>    
							<div class="form-group">
                                <label class="control-label">E-mail</label>
                                <input class="input" class="form-control" type="email" name="E-mail" v-model="formData.email">
								
                            </div>
                            <div class="form-group">
                                <label class="control-label">Mobile</label>
                                <input class="input" class="form-control" type="number" name="mobile" v-model="formData.mobile">
								
                            </div>
                              <div class="form-group">
                                <label class="control-label" for="gender">Gender</label>

								<select class="form-control" name="gender" id="gender" v-model="formData.gender">
								  <option value=""></option>
								  <option value="1">Male</option>
								  <option value="2">Female</option>
								</select>
                            </div>
                              <div class="form-group">
                                <label class="control-label" for="status">Status</label>
                                <select class="form-control" name="status" id="status" v-model="formData.status">
								  <option value=""></option>
								  <option value="1">Active</option>
								  <option value="2">Inactive</option>
								</select>
								
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="role">Role</label>
                                <select class="form-control" name="role" id="role" v-model="formData.role">
								  <option value=""></option>
								  <option value="1">Administrator</option>
								  <option value="2">Pass Issuer</option>
								  <option value="3">Reception</option>
								</select>
								
                            </div>
                <footer class="modal-card-foot" style="justify-content: flex-end;">
                        <button v-if="!isEditing" class="button is-primary" @click="createContact()">Add</button>
                        <button v-if="isEditing" class="button is-primary" @click="changeContact()">Save</button>
                </footer>
                </form>

                  </div>
                  <button class="modal-close is-large" aria-label="close" @click="closeModal()"></button>
            </div>
			
			 
			
			
			
		</div>
	</div>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vuex/2.1.1/vuex.min.js"></script>

<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>-->
<script src='https://cdnjs.cloudflare.com/ajax/libs/vuejs-datepicker/1.5.4/vuejs-datepicker.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/vue-flatpickr-component@8'>
<script src='https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.6/require.min.js'></script>


<script>


	Vue.component('flat-pickr',{
	  props:['value', 'config']
	});

const loading= true;
   const app = new Vue({
        el: '#vue_contacts',
         components:  {
			vuejsDatepicker,'flat-pickr' : VueFlatpickr
		  },
        data: {
				date: null,
                dateTime: '',
                config: {wrap: true,
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",
                defaultDate: null,
                minuteIncrement: "1",
                time_24hr: true
			},
			formData:{
				date: '',
                time: '',
				start_date:'',
				end_date:'',
                description: '',
                comments: '',
                id: 0,
                index: '',
                officer: 0
			},
            time:null,
            search: '',
            showDisabled: 0,
            labelDisabled: 'Show Disabled',
            contacts: [],
			isLoaded:false,
			isAuthenticate:false,
			userName:'',
            isEditing: false,
            isModalOpen: false,
            isModalIn: false,
            isModalOut: false,
            modalTitle: 'Reception Update'
        },
        mounted: function() {
           
		
            let self = this;
            window.addEventListener('keyup', function(event) {
                // If  ESC key was pressed...
                if (event.keyCode === 27) {
                    // try close your dialog
                    self.isModalOpen = false;
                }
            });
            this.getContacts()
			this.loading = false;
        },
        computed: {
            
        },
        methods: {
            getBangla:function(english_number){
			var finalEnlishToBanglaNumber={'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
 
				String.prototype.getDigitBanglaFromEnglish = function() {
					var retStr = this;
					for (var x in finalEnlishToBanglaNumber) {
						 retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
					}
					return retStr;
				};
				 
				return bangla_converted_number=english_number.getDigitBanglaFromEnglish();
 
			},
			dateFormate: function(getDate){
			const date = new Date(getDate)
			const dateTimeFormat = new Intl.DateTimeFormat('en', { year: 'numeric', month: 'short', day: '2-digit' }) 
			const [{ value: month },,{ value: day },,{ value: year }] = dateTimeFormat .formatToParts(date ) 
			console.log(this.getBangla(day));
			return `${day}-${month}-${year }`;
			
			//console.log(`${day}-${month}-${year}`) // just for fun

			},
			dayName: function(dateString){
				var days = ['রবি বার', 'সোমবার', 'মঙ্গলবার', 'বুধবার','বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
				var d = new Date(dateString);
				var dayName = days[d.getDay()];
				return dayName
			},
            getContacts: function() {
                axios.get('../api/getusers.php')
                    .then(function(response) {
                        
                        app.contacts = response.data.result;
						app.isLoaded = true;
						app.isAuthenticate = true;
						//app.userName = response.data.message.isAuthenticate;
						//console.log(response.data.message.isAuthenticate);
						//console.log(response.data.result);
						// Check the response was a success
						console.log(response);
						if(response.data.message === 'success')
						{
							//this.user = response.data.user;
							//app.user_loggedin=0
							
						}
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            openModal: function() {
                this.isModalOpen = true;
            }, 
			openModalIn: function() {
                this.isModalIn = true;
            },
			closeModalIn: function() {
                this.isModalIn = false;
            },
			openModalOut: function() {
                this.isModalOut = true;
            },
			closeModalOut: function() {
                this.isModalOut = false;
            },
            toggleDisabled: function() {
                this.showDisabled = (this.showDisabled === 1) ? 0 : 1;
                this.labelDisabled = (this.showDisabled === 1) ? 'Show Active' : 'Show Disabled';

            },
            openCreateModal: function() {
                this.resetForm();
                this.openModal();

            },
            closeModal: function() {
                this.isModalOpen = false;
            },
            createContact: function() {
                //console.log("Create contact!")
                var self = this;
				 
				//var formData = this.gatherFormData();
				//console.log(this.formData);
				
                this.openModal();
                let formData = new FormData();
                //console.log("date:", this.formData.date, "date:", this.formData.date)
                formData.append('name', this.formData.name || '')
                formData.append('email', this.formData.email || '')
                formData.append('designation', this.formData.designation || '')
                formData.append('role', this.formData.role || '')
                formData.append('status', this.formData.status || 0)
                formData.append('mobile', this.formData.mobile || '')
				formData.append('insertdata', 1);
                formData.forEach(function(value, key) {
                    //contact[key] = value;
                    //console.log(value);
                });
			
				
                axios({
                        method: 'post',
                        url: '../api/getusers.php',
                        data: formData,
                        config: { headers: { 'Content-Type': 'multipart/form-data' } }
                    })
                    .then(function(response) {
						app.isLoaded = true;
						//this.contacts.push({"name": "test"}); 
						
						if(response.data.message === 'success')
						{
							//this.user = response.data.user;
							//app.user_loggedin=0
							
						}
                        app.resetForm()
						app.getContacts()

                    })
                    .catch(function(response) {
                        //handle error
                        console.log(response)
                    })
                // this.getContacts()
                // this.$forceUpdate()
            },
			
            editContact: function(contact, index) {
                this.formData = contact;
                this.isEditing = true;
                this.modalTitle = 'Edit';
                this.openModal();
            },
            deleteContact: function(contact, index) {
				 this.formData = contact;
                if (confirm("Are you sure you want to delete, " + contact.id + "?")) {
                    //console.log("Deleting: " + contact.id + " Index: " + index);
                    let formData = new FormData();
                    formData.append('id', contact.id)
                    formData.append('action', 'delete')
                    axios({
                            method: 'post',
                            url: 'api/contacts.php',
                            data: formData,
                            config: { headers: { 'Content-Type': 'multipart/form-data' } }
                        })
                        .then(function(response) {
                            console.log(response)
							//app.contacts.splice(contact, index) 
                            app.getContacts()
                            app.resetForm();
                        })
                        .catch(function(response) {
                            //handle error
                            //console.log(response)
                        });
                }
            },
            InContact: function() {
				this.isModalIn();
				
			},
            changeContact: function() {
                console.log("Change contact!")

                let formData = new FormData();
                console.log("date:", this.formData.date, "id:", this.formData.id, " key:", this.formData.index)
                formData.append('id', this.formData.id)
                //formData.append('date', this.formData.date || '')
                //formData.append('time', this.formData.time || '')
                formData.append('description', this.formData.description || '')
                formData.append('comments', this.formData.comments || '')
                formData.append('officer', this.formData.officer || 0)
                var contact = {};
                formData.forEach(function(value, key) {
                    contact[key] = value;
                });

                axios({
                        method: 'post',
                        url: 'api/contacts.php',
                        data: formData,
                        config: { headers: { 'Content-Type': 'multipart/form-data' } }
                    })
                    .then(function(response) {
                        //handle success
                        console.log(response)
                       // Vue.set(app.filteredContacts, app.index, contact)
                        app.resetForm();
                    })
                    .catch(function(response) {
                        //handle error
                        console.log(response)
                    });
            },
            resetForm: function() {
                this.formData = {};
                this.isEditing = false;
                this.closeModal();

            },  
			search_active: function(data) {
                console.log(data)
				
				axios({
                        method: 'get',
                        url: 'api/contacts.php',
                        data: data,
                        config: { headers: { 'Content-Type': 'multipart/form-data' } }
                    })
                    .then(function(response) {
                        app.contacts = response.data.result;
						app.isLoaded = true;
                       
                    })
                    .catch(function(response) {
                        //handle error
                        console.log(response)
                    });

            },
			
            changecss(){
                    console.log('changecss')
                    this.cssPagedMedia.size = (size)=>{
                        this.cssPagedMedia('@page {size: ' + size + '}');
                    };
                    this.cssPagedMedia.size(this.pagesize);
                },
                printpage(){
                  window.print()        
                }
        }
    });

</script>
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
