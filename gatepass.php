<?php include 'front-header.php';
if(strlen($_SESSION['alogin'])==0)
{	
    header('location:login/index.php');
}elseif(strlen($_SESSION['alogin'])>0){
    if($_SESSION['role'] != 'Pass Issuer'){
        echo '<br><br><h1 style="margin-top;20px;color:red;font-size:24px;" class="text-center">You have no access this page.</h1>';
       exit;
    }
}
?>

<section class="section" style="padding-bottom:50px;">
    <div class="container">
        <div v-cloak id="vue_appointment">
            <div id="myloader">
                <div class="modal" :class="{ 'is-active': isModalOpen }">
                    <div class="modal-background" @click="closeModal()"></div>
                    <div class="modal-card">
                        <header class="modal-card-head">
                            <p class="modal-card-title">{{ modalTitle }}</p>
                            <p><span class="danger">*</span> fields are mandatory.  </p>
                            <button class="delete" aria-label="close" @click="closeModal()"></button>
                        </header>
                        <section class="modal-card-body">
                            <form v-on:submit.prevent>

                                <div class="form-group" :class="{'has-error': errors.has('formData.visitor_name') }">
                                    <label class="control-label" for="visitor_name">Visitor Name<span class="danger">*</span></label>

                                    <input v-model="formData.visitor_name" v-validate.initial="formData.visitor_name"
                                        data-rules="required|min:3" name="visitor_name"  class="form-control" type="text"
                                        placeholder="Vistor Name">
                                    <p class="text-danger" v-if="errors.has('formData.visitor_name')">
                                    Required field</p>
                                </div>
                                <div class="form-group" :class="{'has-error': errors.has('formData.address') }">
                                    <label class="control-label" for="address">Address<span class="danger">*</span></label>

                                    <input v-model="formData.address" v-validate.initial="formData.address"
                                        data-rules="required|min:3" name="address"  class="form-control" type="text"
                                        placeholder="Address">
                                    <p class="text-danger" v-if="errors.has('formData.visitor_name')">
                                    Required field</p>
                                </div>

                                <div class="form-group" :class="{'has-error': errors.has('formData.designation') }">
                                    <label class="label align-left">Designation</label>
                                    <input class="input" type="text" name="designation" v-model="formData.designation"
                                        ata-rules="alpha" placeholder="Designation">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group" :class="{'has-error': errors.has('formData.date') }">
                                            <label class="label">Date<span class="danger">*</span></label>
                                            <flat-pickr v-model="formData.date" v-validate.initial="formData.date"
                                                data-rules="required" class="form-control" placeholder="Select time"
                                                name="date">
                                            </flat-pickr>
                                            <p class="text-danger" v-if="errors.has('formData.date')">Required field</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group" :class="{'has-error': errors.has('formData.time') }">
                                        <label class="label">Time<span class="danger">*</span></label>
                                        <div class="input-group ">
                                            <flat-pickr v-model="formData.time" v-validate.initial="formData.time"
                                                data-rules="required" :config="config" class="form-control"
                                                placeholder="Select time" name="time">
                                            </flat-pickr>
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="button" title="Toggle"
                                                    data-toggle>
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
                                        <p class="text-danger" v-if="errors.has('formData.time')">Required field</p>
                                    </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="label" style="text-align:left">Email</label>
                                    <input class="input" type="email" name="email" v-model="formData.email"
                                        placeholder="E-mail">

                                </div>
                                <div class="form-group" :class="{'has-error': errors.has('formData.mobile') }">
                                    <label class="control-label" for="mobile">Mobile Number<span class="danger">*</span></label>

                                    <input v-model="formData.mobile" v-validate.initial="formData.mobile"
                                        data-rules="required|digits:11" class="form-control" type="text"
                                        placeholder="Mobile Number">
                                        <p class="text-danger" v-if="errors.has('formData.mobile')">
                                        Mobile number must have 11 digit</p>
                                </div>

                                <div class="form-group">
                                    <label class="label align-left">Comments</label>
                                    <input class="input" type="comments" name="comments" v-model="formData.comments"
                                        placeholder="Comments">
                                </div>

                        </section>

                        <footer class="modal-card-foot" style="justify-content: flex-end;">
                            <div v-if="ajaxloading==true" class="fa-2x text-center" style="margin-right:20px">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                            <button v-if="!isEditing" class="button is-primary" @click="createGatepass()">Add</button>
                            <button v-if="isEditing" class="button is-primary" @click="changeGatepass()">Save</button>
                        </footer>
                        </form>

                    </div>
                    <button class="modal-close is-large" aria-label="close" @click="closeModal()"></button>
                </div>


                <div class="container noprint">
                    <vue-snotify></vue-snotify>

                </div>

                <div class="tabs noprint">
                    <ul>
                        <li :class="{ 'is-active': !showDisabled }" @click="search_active('active')"><a>Active</a></li>
                        <li :class="{ 'is-active': showDisabled }" @click="search_active('previous')"><a>Previous</a>
                        </li>
                        <li>
                            <div class="noprint"><button @click="printpage">Printing</button</div>
                        </li>
                    </ul>
                    <div style="text-align:right;margin-top:15px">

                        <button style="text-align:right;" class="button is-primary" @click="openModal()"><i
                                class="fa fa-plus"></i></button>
                    </div>
                </div>


                <div class="table-responsive">
                    <div id="loader" v-if="isLoaded==false" class="fa-3x">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <table class="table is-striped is-hoverable" width="100%">
                        <thead>
                            <tr>
                                <th>Date </th>
                                <th>Time &nbsp;</th>
                                <th>Visitor Name</th>
                                <th>Address</th>
                                <th>Designation</th>
                                <th>Mobile/E-Mail</th>
                                <th>Comments</th>

                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(gatepass, index) in gatepasses" :key="gatepass.id">
                                <td width="150">{{ gatepass.date }} </td>
                                <td>{{ gatepass.time }}</td>
                                <td>{{ gatepass.visitor_name }}</td>
                                <td>{{ gatepass.address }}</td>
                                <td>{{ gatepass.designation }}</td>
                                <td>
                                    {{ gatepass.mobile }}<br>
                                    {{ gatepass.email }}
                                </td>
                                <td>{{ gatepass.comments }}</td>

                                <td class="edit noprint">
                                           
                                <div v-if="isPrevious==false">
                                        <span class="edit noprint" 
                                            @click="editGatepass(gatepass, index)"><i
                                            class="fa fa-edit"></i></span>  &nbsp&nbsp
                                            
                                            <span class="fa fa-window-close noprint"
                                            @click="deleteGatepass(gatepass, index)"></span>
                                            </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>

</section>

<?php include 'include/footer-text.php';?>

<script src="//unpkg.com/axios/dist/axios.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script src="//cdn.jsdelivr.net/g/lodash@4.17.2,vee-validate@2.0.0-beta.14"></script>
<script src='//unpkg.com/vue-snotify@3.2.1/vue-snotify.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/vuejs-datepicker/1.5.4/vuejs-datepicker.min.js'></script>
<script src='//cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.js'></script>
<script src='//cdn.jsdelivr.net/npm/vue-flatpickr-component@8'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.6/require.min.js'></script>

<script>
    //localStorage.setItem('token', response.data.token);
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
Vue.use(VeeValidate)
Vue.component('flat-pickr', {
    props: ['value', 'config']
});

var app = new Vue({
    el: '#vue_appointment',
    components: {
        'flat-pickr': VueFlatpickr
    },
    data: {
        title: 'test',
        showError: false,
        date: null,
        dateTime: '',
        config: {
            wrap: true,
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            defaultDate: "null",
            minuteIncrement: "1",
            time_24hr: false,  
        },
        formData: {
            date: '',
            time: '',
            visitor_name: '',
            address: '',
            designation: '',
            mobile: '',
            email: '',
            comments: '',
            id: 0,
            index: ''
        },
        time: null,
        ajaxloading: false,
        isPrevious:false,
        showDisabled: 0,
        gatepasses: [],
        isLoaded: false,
        isLoading: false,
        isEditing: false,
        isModalOpen: false,
        modalTitle: '',
        formSubmitted: false
    },
    created: function() {
        this.isLoading = true;
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
        this.getGatepass()
        this.loading = false;

        //this.isLoading=false;
    },
    computed: {

    },
    methods: {
        toggleShowError() {
            this.showError = !this.showError;
        },
        show(message) {
            //console.log('test');
            // this.$notify({ group: 'auth', text: 'aaa' });
            this.$snotify.success(message);
        },
        getGatepass: function() {
            axios.get('api/issue-gatepass.php?action=active')
                .then(function(response) {

                    app.gatepasses = response.data.result;
                    app.isLoaded = true;
                    console.log('Response:', JSON.stringify(response, null, 2))
                    this.isLoading = false;
                    if (response.data.message === 'success') {
                        //this.user = response.data.user;
                        //app.user_loggedin=0

                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        createForm:function(){
            app.errors.clear();
            this.resetForm();
            this.ajaxloading = false;
            this.isModalOpen = true;
        },
        openModal: function() {
            app.errors.clear();
            this.modalTitle="Add";
            this.ajaxloading = false;
            this.isModalOpen = true;
            this.formData.date=new Date().toLocaleString();
        },
        closeModal: function() {
            app.errors.clear();
            this.isModalOpen = false;
            this.resetForm();
        },
        validateBeforeSubmit(e) {
            this.$validator.validateAll();
            if (!this.errors.any()) {
                this.submitForm()
            }
        },
        submitForm() {
            this.formSubmitted = true
        },
        createpassForm() {

            this.openModal();
            this.$validator.validateAll();
            if (this.errors.any()) {
                return false;
            }
            console.log(this.errors);
        },
        createGatepass: function() {
            this.$validator.validateAll();
            if (!this.errors.any()) {
                this.formSubmitted = true
                console.log(this.errors)
            } else {
                return false;
            }
            this.ajaxloading = true;
            var self = this;

            let formData = new FormData();

            formData.append('date', this.formData.date || '')
            formData.append('time', this.formData.time || '')
            formData.append('mobile', this.formData.mobile || '')
            formData.append('email', this.formData.email || '')
            formData.append('visitor_name', this.formData.visitor_name || '')
            formData.append('address', this.formData.address || '')
            formData.append('designation', this.formData.designation || '')
            formData.append('comments', this.formData.comments || '')
            formData.append('action', 'insert');
            formData.forEach(function(value, key) {
                //gatepass[key] = value;
                //console.log(value);
            });

            app.isLoaded = false;
            axios({
                    method: 'post',
                    url: 'api/issue-gatepass.php',
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                })
                .then(function(response) {
                  
                    if (response.data.message === 'success') {
                        app.isLoaded = true;
                       
                        //this.gatepasses.push({date:"",time:"",mobile:"",email:"",visitor_name});
                        //console.log(response);
                        app.ajaxloading = true;
                        //app.resetForm();
                        app.isModalOpen=false;
                        app.getGatepass();
                        app.show('Data updated successfully.');
                    }
                 
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                })
            //app.getGatepass();
            console.log('done');
        },
        editGatepass: function(gatepass, index) {
            this.isLoaded = true;
           app.formData = gatepass;
           this.isModalOpen=true;
            this.isEditing = true;
            this.ajaxloading = false;
            this.modalTitle = 'Edit';
            //app.resetForm();
            //this.openModal();
        },
        deleteGatepass: function(gatepass, index) {
            app.isLoaded = false;

            if (confirm("Are you sure you want to delete?")) {
                //console.log("Deleting: " + gatepass.id + " Index: " + index);
                let formData = new FormData();
                formData.append('id', gatepass.id)
                formData.append('action', 'delete')
                axios({
                        method: 'post',
                        url: 'api/issue-gatepass.php',
                        data: formData,
                        config: {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    })
                    .then(function(response) {
                        console.log(response)
                        app.gatepasses.splice(index, 1)
                        app.show('Data deleted successfully.');
                        //app.getGatepass()
                        //app.resetForm();
                        app.isLoaded = true;
                    })
                    .catch(function(response) {
                        //handle error
                        //console.log(response)
                    });
            }
        },
        changeGatepass: function() {
            this.$validator.validateAll();
            if (!this.errors.any()) {
                this.submitForm()
                this.formSubmitted = true
            } else {
                return false;
            }
            console.log();
            app.isLoaded = false;
            app.ajaxloading=true;
            let formData = new FormData();
            //console.log("date:", this.formData.date, "id:", this.formData.id, " key:", this.formData.index)
            formData.append('id', this.formData.id)
            formData.append('visitor_name', this.formData.visitor_name || '')
            formData.append('address', this.formData.address || '')
            formData.append('date', this.formData.date || '')
            formData.append('time', this.formData.time || '')
            formData.append('description', this.formData.description || '')
            formData.append('comments', this.formData.comments || '')
            formData.append('designation', this.formData.designation || '')
            formData.append('email', this.formData.email || '')
            formData.append('mobile', this.formData.mobile || '')
            formData.append('action', 'save')
            var gatepass = {};
            formData.forEach(function(value, key) {
                gatepass[key] = value;
            });
            app.isLoaded = false;
            axios({
                    method: 'post',
                    url: 'api/issue-gatepass.php',
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                })
                .then(function(response) {
                    //handle success
                    if (response == 'success') {
                        app.ajaxloading = false;
                     

                    }
                    console.log(response)
                    // Vue.set(app.filteredGatepasss, app.index, gatepass)
                    app.resetForm();
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
            app.isLoaded = true;
            app.show('Data updated successfully.');
        },
        resetForm: function() {
            this.formData = {};
            this.isEditing = false;
            this.closeModal();

        },
        search_active: function(active) {
            this.showDisabled = (this.showDisabled === 1) ? 0 : 1;
            app.isLoaded = false;
            axios.get("api/issue-gatepass.php?action=" + active)
                .then(function(response) {
                    app.gatepasses = response.data.result;
                    app.isLoaded = true;
                    console.log(active)
                    if(active==='previous'){
                        app.isPrevious=true;
                    }else{
                        app.isPrevious=false;
                    }

                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });

        },
        printpage() {
            window.print();
        }
    }
});
</script>
<style>
#ajaxloading {
    display: none;
}

.label {
    padding: 0;
}

.align-left {
    text-align: left;
}

.notifications {
    position: fixed;
    right: 10px;
    top: 10px;
    width: 350px;
    z-index: 1;
}

.notification p {
    margin-right: 20px;
}
.danger{color:red;font-weight: bold;}
</style>

</body>

</html>