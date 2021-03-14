<?php include 'front-header.php';
if(strlen($_SESSION['alogin'])==0)
{	
    header('location:login/index.php');
}elseif(strlen($_SESSION['alogin'])>0){
    if($_SESSION['role'] != 'Pass Issuer'){
       echo 'You have no access this page.';
    }
}
?>

<section class="section">
    <div class="container">
        <div v-cloak id="vue_appointment">
            <div id="myloader">
            <div class="modal" :class="{ 'is-active': isModalOpen }">
                  <div class="modal-background" @click="closeModal()"></div>
                  <div class="modal-card">
                        <header class="modal-card-head">
                            <p class="modal-card-title">{{ modalTitle }}</p>
                            <button class="delete" aria-label="close" @click="closeModal()"></button>
                        </header>
                        <section class="modal-card-body">
                        <form v-on:submit.prevent>
						    
                            <div class="field">
                                <label class="label">Name</label>
                                <input class="input" type="text" name="visitor_name" v-model="formData.visitor_name" required>
                            </div>   
							<div class="field">
                                <label class="label">Designation</label>
                                <input class="input" type="text" name="designation" v-model="formData.designation" required>
                            </div>
							<div class="row">
								<div class="col-lg-6">
									<label class="label">Date</label>
										<flat-pickr
												v-model="formData.date"              
												class="form-control" 
												placeholder="Select time"     
												name="date">
										</flat-pickr>
									
								</div>
								<div class="col-lg-6">
								  <label class="label">Time</label>
								  <div class="input-group">
									<flat-pickr
											v-model="formData.time"
											:config="config"               
											class="form-control" 
											placeholder="Select time"     
											name="time">
									</flat-pickr>
									<div class="input-group-btn">
									  <button class="btn btn-default" type="button" title="Toggle" data-toggle>
										<i class="fa fa-clock-o">
										  <span aria-hidden="true" class="sr-only">Toggle</span>
										</i>
									  </button>
									  <button class="btn btn-default" type="button" title="Clear" data-clear>
										<i class="fa fa-times">
										  <span aria-hidden="true" class="sr-only">Clear</span>
										</i>               
									  </button>
									</div>
								  </div>
								</div>
							</div>
                    
                         
                            <div class="field">
                                <label class="label">Email</label>
                                <input class="input" type="email" name="email" v-model="formData.email">
								
                            </div>
                            <div class="field">
                                <label class="label">Mobile</label>
                                <input class="input" type="number" name="mobile" v-model="formData.mobile">
								
                            </div>
							<div class="field">
                                <label class="label">Comments</label>
                                <input class="input" type="comments" name="comments" v-model="formData.comments">
                            </div>
                            
                        </section>
                        <div id="ajaxloading" style="background:#fff;display:block;text-align:center;"
                            v-if="isLoaded==false">
                            <div class="fa-3x text-center">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </div>
                <footer class="modal-card-foot" style="justify-content: flex-end;">
                        <button v-if="!isEditing" class="button is-primary" @click="createContact()">Add</button>
                        <button v-if="isEditing" class="button is-primary" @click="changeContact()">Save</button>
                </footer>
                </form>

                  </div>
                  <button class="modal-close is-large" aria-label="close" @click="closeModal()"></button>
            </div>
    <div>
  
			
            <div class="container noprint">
                <h2 class="text-center">Bangladesh Bridge Authority Gatepass Management System</h2>
                <div class="field" style="text-align:right">
			
                  <button style="text-align:right;" class="button is-primary" @click="openCreateModal()"><i class="fa fa-plus"></i></button>            
                </div>
            </div>

            <div class="tabs noprint">
              <ul>
                <li :class="{ 'is-active': !showDisabled }" @click="search_active('active')"><a>Active</a></li>
                <li :class="{ 'is-active': showDisabled }" @click="search_active('inactive')"><a>Previous</a></li>
                <li>  <div class="noprint"><button  @click="printpage">Printing</button</div></li>		
              </ul>
            </div>

    </div>

       <div id="print">
	     <div id="loader" v-if="isLoaded==false" class="fa-3x">
         <i class="fa fa-spinner fa-spin"></i>
		</div>
		<table class="table is-striped is-hoverable" width="100%">
            <thead>
                <tr>
				<th>Date </th>
				<th>Time &nbsp;</th>
				<th>Visitor Name</th>
               <th>Designation</th>
				<th>E-Mail/Mobile</th>
				<th>Comments</th>
               
                <th>&nbsp;</th> 
                </tr>
            </thead>
            <tbody>
                <tr v-for="(contact, index) in contacts" :key="contact.id">
                    <td width="150">{{ contact.date }} </td>
                    <td>{{ contact.time }}</td>
                    <td>{{ contact.visitor_name }}</td>
                    <td>{{ contact.designation }}</td>
                    <td>
                        {{ contact.mobile }}<br>
                        {{ contact.email }}
                    </td>
                    <td>{{ contact.comments }}</td>
                    
					<td   class="edit noprint">
						<span class="edit noprint" @click="editContact(contact, index)"><i class="fa fa-edit"></i></span>  <span class="fa fa-window-close noprint" @click="deleteContact(contact, index)"></span>
                    </td>
                </tr>
            </tbody>
        </table>
	
		</div>
       </div>

    </div>

</section>
<?php include 'include/footer-text.php';?>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/vuejs-datepicker/1.5.4/vuejs-datepicker.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/vue-flatpickr-component@8'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.6/require.min.js'></script>

<script>

	Vue.component('flat-pickr',{
	  props:['value', 'config']
	});

    app = new Vue({
        el: '#vue_appointment',
         components:  {
			vuejsDatepicker,'flat-pickr' : VueFlatpickr
		  },
        data: {
			date: null,
            dateTime: '',
            config: {
                    wrap: true,
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
				visitor_name:'',
				designation:'',
                mobile: '',
                email: '',
                comments: '',
                id: 0,
                index: ''
            },
            time:null,
            showDisabled: 0,
            contacts: [],
            isLoaded:false,
            isLoading:false,
            isEditing: false,
            isModalOpen: false,
            modalTitle: 'নতুন কার্যক্রম'
        },
        created:function(){
            this.isLoading=true;
        },
        mounted: function() {
            //this.isLoading=true;
		
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
           
            //this.isLoading=false;
        },
        computed: {
            
        },
        methods: {
          
            getContacts: function() {
                axios.get('api/issue-gatepass.php')
                    .then(function(response) {
                        
                        app.contacts = response.data.result;
						app.isLoaded = true;
                        console.log('Response:', JSON.stringify(response, null, 2))
                        this.isLoading=false;
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
            openCreateModal: function() {
                this.resetForm();
                this.openModal();

            },
            closeModal: function() {
                this.isModalOpen = false;
            },
            createContact: function() {
                this.isLoaded=false;
                var self = this;
                this.openModal();
                let formData = new FormData();
               
                formData.append('date', this.formData.date || '')
                formData.append('time', this.formData.time || '')
                formData.append('mobile', this.formData.mobile || '')
                formData.append('email', this.formData.email || '')
                formData.append('visitor_name', this.formData.visitor_name || '')
                formData.append('designation', this.formData.designation || '')
                formData.append('comments', this.formData.comments || '')
                formData.append('insertdata', 1);
                formData.forEach(function(value, key) {
                    //contact[key] = value;
                    //console.log(value);
                });
			
				
                axios({
                        method: 'post',
                        url: 'api/issue-gatepass.php',
                        data: formData,
                        config: { headers: { 'Content-Type': 'multipart/form-data' } }
                    })
                    .then(function(response) {
						app.isLoaded = true;
						console.log(response);
						
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
                this.isLoaded = true;
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
            changeContact: function() {
                app.isLoaded=false;
                let formData = new FormData();
                console.log("date:", this.formData.date, "id:", this.formData.id, " key:", this.formData.index)
                formData.append('id', this.formData.id)
                formData.append('visitor_name', this.formData.visitor_name || '')
                formData.append('date', this.formData.date || '')
                formData.append('time', this.formData.time || '')
                formData.append('description', this.formData.description || '')
                formData.append('comments', this.formData.comments || '')
                formData.append('designation', this.formData.designation || '')
                formData.append('email', this.formData.email || '')
                formData.append('mobile', this.formData.mobile || '')
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
                    app.isLoaded=true;
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
                printpage(){
                  window.print();      
                }
        }
    });

</script>
<style>
    #ajaxloading {
    display: none;
}
</style>

</body>
</html>