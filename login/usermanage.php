<?php
session_start();
error_reporting(0);
include('includes/dbconfig.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
elseif(isset($_SESSION['role']) && ($_SESSION['role']!='Administrator')){
    header('location:index.php');
}else{

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

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons'>
   
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/vuetify@1.5.16/dist/vuetify.min.css'>
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
		<?php //include('includes/leftbar.php');?>
		<div class="content-wrapper" v-cloak id="app">
			<div class="container">

				<div class="row">
					<div class="col-md-12 panel panel-default">
						<h2 class="page-title text-center">User Manage</h2><br><br>
                        <v-app id="inspire">
                          <v-toolbar dark color="primary" fixed>
                            <v-toolbar-title class="white--text">Users</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
                            <v-menu offset-y :nudge-left="170" :close-on-content-click="false">
                                <v-btn icon slot="activator">
                                    <v-icon>more_vert</v-icon>
                                  </v-btn>
                                <v-list>
                                  <v-list-tile  v-for="(item, index) in headers"  :key="item.value"   @click="changeSort(item.value)">
                                    <v-list-tile-title>{{ item.text }}<v-icon v-if="pagination.sortBy === item.value">{{pagination.descending ? 'arrow_downward':'arrow_upward'}}</v-icon></v-list-tile-title>
                                  </v-list-tile>
                                </v-list>
                              </v-menu>
                          </v-toolbar>
                              <v-layout style="padding-top:20">
                                <v-data-table :headers="headers" :items="users" :search="search" :pagination.sync="pagination"   >
                                  <template  slot="items" slot-scope="props">
                                    <tr>
                                      <td >{{ props.item.name }}</td>
                                      <td>{{ props.item.designation }}</td>
                                      <td>{{ props.item.mobile }}</td>
                                      <td>{{ props.item.email }}</td>
                                      <td>
                                  
                                        <div v-if="props.item.role=='1'">
                                             Administrator
                                        </div>
                                        <div v-else-if="props.item.role=='2'">
                                        Pass Issuer
                                        </div>
                                        <div v-else>
                                        Reception
                                        </div>
                                      </td>
                                      <td>
                                      <p v-if="props.item.status==1">Active</p>
                                        <p v-else>In Active</p>
                                      
                                      </td>
                                      <td class="text-xs-right">
                                            <v-btn icon class="mx-0">
                                            <v-icon color="pink" @click="editContact(  props.item,props.index)" > edit</v-icon>
                                          </v-btn>
                                          <v-btn icon class="mx-0">
                                            <v-icon color="pink" @click="deleteUser(  props.item,props.index)" > delete</v-icon>
                                          </v-btn>
                                      </td>
                                    </tr>
                             
                                  </template>
                                 
                                  <v-alert slot="no-results" :value="true" color="error" icon="warning">
                                    Your search for "{{ search }}" found no results.
                                  </v-alert>
                                </v-data-table>
                              </v-layout>
                        </v-app>
					
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
                        <input type="hidden" id="user_id" name="user_id" v-model="formData.user_id">
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
                        <button v-if="isEditing" class="button is-primary" @click="changeUser()">Save</button>
                </footer>
                </form>

                  </div>
                  <button class="modal-close is-large" aria-label="close" @click="closeModal()"></button>
            </div>
		</div>
	

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/vue-flatpickr-component@8'></script>
    <script src='https://cdn.jsdelivr.net/npm/vuetify@1.5.16/dist/vuetify.min.js'></script>

    <script>
        Vue.component('flat-pickr', {
            props: ['value', 'config']
        });
    
        app = new Vue({
            el: '#app',
            components: {
                'flat-pickr': VueFlatpickr
            },
            data: {
                dataTable:null,
                expand: false,
                search: '',
                pagination: {
                    sortBy: 'name'
                  },
                  
                headers: [
                    {
                        text: 'Name',
                        align: 'left',
                        sortable: false,
                        value: 'name'
                    },

                    {
                        text: 'Designation',
                        value: 'designation'
                    },
                    {
                        text: 'Mobile',
                        value: 'mobile'
                    },
                    {
                        text: 'Email',
                        value: 'email'
                    },
                    {
                        text: 'Role',
                        value: 'role'
                    },
                    {
                        text: 'Status',
                        value: 'staus'
                    },
                    {
                        text: '',
                        value: ''
                    }
                ],
                formData: {
                    name: '',
                    designation: '',
                    email: '',
                    mobile: '',
                    status: '',
                    role: '',
                    id: 0
                    
                },
                users: [],
                isLoaded: false,
                isEditing: false,
                isModalOpen: false,
                modalTitle: 'New'
            },
            mounted: function () {

                //this.dataTable = $('#user-table').DataTable({});
                let self = this;
                window.addEventListener('keyup', function (event) {
                    // If  ESC key was pressed...
                    if (event.keyCode === 27) {
                        // try close your dialog
                        self.isModalOpen = false;
                    }
                });
                this.getUsers()
                this.loading = false;
            },
            computed: {
              
            
            },
            methods: {
               
                getUsers: function () {
                    axios.get('../api/getusers.php')
                        .then(function (response) {
                            app.users = response.data.result;
                            app.isLoaded = true;
                        
                            console.log(response);
                            if (response.data.message === 'success') {
                                //this.user = response.data.user;
                                //app.user_loggedin=0

                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                openModal: function () {
                    this.isModalOpen = true;
                },
                closeModal: function () {
                    this.isModalOpen = false;
                },
                createContact: function () {
                    //console.log("Create contact!")
                    var self = this;
                    this.openModal();
                    let formData = new FormData();
                    //console.log("date:", this.formData.date, "date:", this.formData.date)
                    formData.append('name', this.formData.name || '')
                    formData.append('designation', this.formData.designation || '')
                    formData.append('email', this.formData.email || '')
                    formData.append('mobile', this.formData.mobile || '')
                    formData.append('status', this.formData.status || 0)
                    formData.append('role', this.formData.role || 0)
                    formData.append('action', 'insert')
                    formData.forEach(function (value, key) {
                        //contact[key] = value;
                        //console.log(value);
                    });


                    axios({
                            method: 'post',
                            url: '../api/getusers.php',
                            data: formData,
                            config: {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }
                        })
                        .then(function (response) {
                            app.isLoaded = true;
                            //this.users.push({"name": "test"}); 

                            if (response.data.message === 'success') {
                                //this.user = response.data.user;
                                //app.user_loggedin=0

                            }
                            app.resetForm()
                            app.getUsers()

                        })
                        .catch(function (response) {
                            //handle error
                            console.log(response)
                        })
                    // this.getUsers()
                    // this.$forceUpdate()
                },
                editContact: function (data,index) {
                    this.formData = data;
                    this.isEditing = true;
                    this.modalTitle = 'সম্পাদন';
                    this.openModal();
                },
                deleteUser: function (user, index) {
                    this.formData = user;
                    if (confirm("Are you sure you want to delete?")) {
                        //console.log("Deleting: " + contact.id + " Index: " + index);
                        let formData = new FormData();
                        formData.append('id', user.user_id)
                        formData.append('action', 'delete')
                        axios({
                                method: 'post',
                                url: '../api/getusers.php',
                                data: formData,
                                config: {
                                    headers: {
                                        'Content-Type': 'multipart/form-data'
                                    }
                                }
                            })
                            .then(function (response) {
                                console.log(response)
                                //app.users.splice(contact, index) 
                                app.getUsers()
                                app.resetForm();
                            })
                            .catch(function (response) {
                                //handle error
                                //console.log(response)
                            });
                    }
                },
                changeUser: function () {
                    //console.log("Change contact!")

                    let formData = new FormData();
                    //console.log("date:", this.formData.date, "id:", this.formData.id, " key:", this.formData.index)
                    formData.append('id', this.formData.user_id)
                    formData.append('name', this.formData.name || '')
                    formData.append('email', this.formData.email || '')
                    formData.append('designation', this.formData.designation || '')
                    formData.append('role', this.formData.role || 0)
                    formData.append('status', this.formData.status || 0)
                    formData.append('action', 'update')
                    console.log( formData)
                    var contact = {};
                    formData.forEach(function (value, key) {
                        contact[key] = value;
                    });

                    axios({
                            method: 'post',
                            url: '../api/getusers.php',
                            data: formData,
                            config: {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }
                        })
                        .then(function (response) {
                            //handle success
                            console.log(response)
                            // Vue.set(app.filteredusers, app.index, contact)
                            app.resetForm();
                        })
                        .catch(function (response) {
                            //handle error
                            console.log(response)
                        });
                },
                resetForm: function () {
                    this.formData = {};
                    this.isEditing = false;
                    this.closeModal();

                }
            }
        });
    </script>

</body>
</html>
<?php } ?>
