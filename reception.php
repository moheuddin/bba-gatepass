<?php include 'front-header.php';
if(strlen($_SESSION['alogin'])==0)
{	
    header('location:login/index.php');
}elseif(strlen($_SESSION['alogin'])>0){
    if($_SESSION['role'] != 'Reception'){
       echo '<br><br><h1 style="margin-top;20px;color:red;font-size:24px;" class="text-center">You have no access this page.</h1>';
       exit;
    }
}
?>

<section class="section" style="padding-bottom:50px;">
    <div class="container">
        <div v-cloak id="vue_appointment">
            <!--<div class="row">
                <div class="col-md-6">
                    <app-component1></app-component1>
                </div>
                <div class="col-md-6">
                    <app-component2></app-component2>
                </div>
            </div>-->

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
                            <fieldset>
                                <legend>IN:</legend>
                                <div class="row">
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                            <label for="in_date" class="label">Date</label>
                                            <flat-pickr v-model="formData.in_date" tabindex="1" class="form-control"
                                                placeholder="Select date" id="in_date" name="in_date">
                                            </flat-pickr>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="in_time" class="label">Time</label>
                                            <div class="input-group">
                                                <flat-pickr v-model="formData.in_time" :config="config" tabindex="2"
                                                    class="form-control" placeholder="Select time" name="in_time" id="in_time">
                                                </flat-pickr>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="button" title="Toggle"
                                                        data-toggle>
                                                        <i class="fa fa-clock-o">
                                                            <span aria-hidden="true" class="sr-only">Toggle</span>
                                                        </i>
                                                    </button>
                                                    <button class="btn btn-default" type="button" title="Clear"
                                                        data-clear>
                                                        <i class="fa fa-times">
                                                            <span aria-hidden="true" class="sr-only">Clear</span>
                                                        </i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="in_card">Card No IN</label>
                                                 <input class="form-control" id="in_card" type="text" name="in_card" tabindex="3"
                                                v-model="formData.in_card">
                                                
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="is_in">Is In</label>
                                            <input class="form-control" name="is_in" id="is_in" type="checkbox" v-model="formData.is_in" true-value="1"
                                                false-value="0" tabindex="4">
                                        </div>
                                    </div>
                                </div>


                            </fieldset>
                            <fieldset>
                            <legend>OUT:</legend>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="out_date" class="label">Date</label>
                                            <flat-pickr v-model="formData.out_date" class="form-control" tabindex="5"
                                                placeholder="Select date" id="out_date" name="out_date">
                                            </flat-pickr>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="out_time">Time</label>
                                            <div class="input-group">
                                                <flat-pickr v-model="formData.out_time" :config="config" tabindex="6"
                                                    class="form-control" placeholder="Select time" name="out_time" id="out_time">
                                                </flat-pickr>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="button" title="Toggle"
                                                        data-toggle>
                                                        <i class="fa fa-clock-o">
                                                            <span aria-hidden="true" class="sr-only">Toggle</span>
                                                        </i>
                                                    </button>
                                                    <button class="btn btn-default" type="button" title="Clear"
                                                        data-clear>
                                                        <i class="fa fa-times">
                                                            <span aria-hidden="true" class="sr-only">Clear</span>
                                                        </i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="card_out">Card Received</label>
                                            <input class="form-control" type="text" name="card_out" id="card_out" tabindex="7"
                                                v-model="formData.card_out">

                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="is_out">Is Out </label>
                                                <input class="form-control" type="checkbox" id="is_out" name="is_out" v-model="formData.is_out" tabindex="8"
                                                    true-value="1" false-value="0" />
                                           
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                              
                         
                            <div class="form-group">
                                <label for="reception_comments">Comments</label>
                                <input style="width:100%" class="form-control" type="text" id="reception_comments" name="reception_comments" tabindex="9"
                                    v-model="formData.reception_comments">
                            </div>
                          
                               
                        </section>


                        <footer class="modal-card-foot" style="justify-content: flex-end;">
                            
                            <button v-if="isEditing" class="button is-primary" @click="changeAppointment()">
                            <div v-if="ajaxloading==true" class="fa-1x text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div> Save</button>
                        </footer>
                        </form>

                    </div>
                    <button class="modal-close is-large" aria-label="close" @click="closeModal()"></button>
                </div>

                <div class="tabs noprint">
                    <ul>
                        <li :class="{ 'is-active': !showDisabled }" @click="search_active('active')"><a>Active</a>
                        </li>
                        <li :class="{ 'is-active': showDisabled }" @click="search_active('previus')">
                            <a>Previous</a>
                        </li>
                        <li>
                            <div class="noprint"><button @click="printpage">Printing</button</div>
                        </li>
                    </ul>
                    
                    <div id=time>
                        <ul><li style="color:red;"><span v-if="checkbox == 1">Auto refresh Started </span> <span v-if="checkbox == '0'">Refresh Stopped</span> <span>{{my_time}}</span></li>
                        <li><div class="panel-body">  
                            <!--Only code you need is this label-->
                            <label class="switch">
                                <input type="checkbox" @click="toggleCheckbox">
                                <div class="slider round"></div>
                            </label>
                            </div></li>
                        </ul>
                        
                          
                            
                    </div>
                </div>
                <vue-snotify></vue-snotify>
                <div class="table-responsive">
                    <div id="loader" v-if="isLoaded==false" class="fa-3x">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <table class="table is-striped is-hoverable" width="100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Visitor Name</th>
                                <th>Address</th>
                                <th>Mobile/E-Mail</th>
                                <th>Pass Issuer</th>
                                <th>IN Date/Time</th>
                                <th>Card No</th>
                                <th>Comments</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(gatepass, index) in gatepasses" :key="gatepass.id">
                                <td width="15">{{gatepass.date }} <br>{{dayName(gatepass.date)}}</td>
                                <td>{{ gatepass.time }}</td>
                                <td>{{ gatepass.visitor_name }}</td>
                                <td>{{ gatepass.address }}</td>
                                <td>
                                    {{ gatepass.mobile }}<br>
                                    {{ gatepass.email }}
                                </td>
                                <td>
                                    {{ gatepass.user_name }}<br>
                                    {{ gatepass.user_designation }}

                                </td>
                                <td>
                                    {{ gatepass.in_date }}<br>
                                    {{ gatepass.in_time }}

                                </td>
                                <td>
                                    {{ gatepass.in_card }}
                                   

                                </td>
                                <td>
                                    {{ gatepass.comments }} <br>
                                    <span v-if="gatepass.reception_comments"> Reception Comment:<br>
                                    {{gatepass.reception_comments}}
                                    </span>

                                </td>

                                <td class="edit noprint">
                                <div v-if="isPrevious==false">
                                    <span class="edit noprint" @click="editAppointment(gatepass, index)"><i
                                            class="fa fa-edit"></i></span>
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

<script src="assets/js/vue.js"></script>
<script src="assets/js/axios.min.js"></script>
<script src='https://unpkg.com/vue-snotify@3.2.1/vue-snotify.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vuejs-datepicker/1.5.4/vuejs-datepicker.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/vue-flatpickr-component@8'></script>

<script type="text/javascript">
var eventBus = new Vue();

Vue.component('app-component1', {
    data: function() {
        return {
            name: 'David Hayden'
        }
    },
    methods: {
        changeName: function() {
            eventBus.$emit('nameChange', this.name);
            this.name = '';
            this.$refs.textbox.focus();
        }
    },
    template: '<div class="well"><h3>Component 1</h3><hr/><form><div class="form-group"><label for="name">Name</label><input type="text" v-model="name" id="name" class="form-control" placeholder="name" @keydown.enter.prevent="changeName" ref="textbox"></div><div class="form-group"><button class="btn btn-primary" @click.prevent="changeName">Change Name</button></div></form></div>'
})

Vue.component('app-component2', {
    data: function() {
        return {
            name: 'David Hayden'
        }
    },
    template: '<div class="well"><h3>Component 2</h3><hr/><p>Name: {{ name }}</p></div>',
    created: function() {
        var that = this;
        eventBus.$on('nameChange', function(newName) {
            that.name = newName;
        })
    }
})

Vue.component('flat-pickr', {
    props: ['value', 'config']
});

app = new Vue({
    el: '#vue_appointment',
    components: {
        'flat-pickr': VueFlatpickr
    },
    title: 'test',
    showError: false,
    data: {
        showLogin: false,
    
        config: {
            wrap: true,
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            defaultDate: null,
            minuteIncrement: "1",
            time_24hr: false
        },
        ajaxloading: false,
        gatepasses: [],
        formData: {
            date: '',
            time: '',
            visitor_name: '',
            address: '',
            designation: '',
            mobile: '',
            email: '',
            is_out: '',
            is_in: '',
            in_date: '',
            out_date: '',
            reception_comments: '',
            comments: '',
            id: 0,
            index: ''
        },
        time: null,
        checkbox: false,
        showDisabled: 0,
        showStartClass:'',
        showStartText:'Next Refresh: ',
        isLoaded: false,
        isLoading: true,
        userName: '',
        isEditing: false,
        isModalOpen: false,
        startRefresh:0,
        t:false,
        hours: 0,
        minutes: 0,
        seconds: 0,
        counter: 0,
        my_timer:0,
        my_time:0,
        isPrevious:false,
        modalTitle: 'Edit'
    },
    created: function() {
        this.isLoading = true;
       
        //this.getAppointment();
    },
    mounted: function() {
        this.getAppointment();
        //setInterval(() => {
        //    this.getAppointment();
        //}, 30000);
        this.autoRefresh();
    },
    computed: {

    },
   
    methods: {
        toggleShowError() {
            this.showError = !this.showError;
        },
        toggleCheckbox() {
                this.checkbox = !this.checkbox
                this.$emit('setCheckboxVal', this.checkbox)
                if(this.checkbox==true){
                    this.timer()
                }else if(this.checkbox==false){
                    this.resetTimer()
                }
            },
        show(message) {
            //console.log('test');
            // this.$notify({ group: 'auth', text: 'aaa' });
            this.$snotify.success(message);
        },
        timer:function() {
            var seconds =60000;
           
            this.my_timer = setInterval(() => {
                var minutesToAdd=1;
                var currentDate = new Date();
                var futureDate = new Date(currentDate.getTime() + minutesToAdd*60000);
                
                this.my_time = '| Next refresh at: '+ futureDate.toLocaleTimeString(); 
                this.seconds = this.timerFormat(++this.counter % 60)
                this.minutes = this.timerFormat(parseInt(this.counter / 60, 10) % 60)
                this.hours = this.timerFormat(parseInt(this.counter / 3600, 10))
                this.getAppointment();
            }, seconds);
        },
        resetTimer:function() {
            this.showStartClass = (this.showStartClass === 1) ? 0 : 1;
            clearInterval(this.my_timer)
            this.hour=0
            this.minutes=0
            this.seconds=0
            this.counter=0
        },
        timerFormat:function(timer) {
            return timer > 9 ? timer : '0' + timer;
        },
        autoRefresh: function() {
            if(this.startRefresh==1){    
                this.startRefresh = setInterval(() => {
                    console.log(this.autoRefresh)
                }, 3000);
            }else{
                clearInterval(this.startRefresh)
            }

        },
        getBangla: function(english_number) {
            var finalEnlishToBanglaNumber = {
                '0': '০',
                '1': '১',
                '2': '২',
                '3': '৩',
                '4': '৪',
                '5': '৫',
                '6': '৬',
                '7': '৭',
                '8': '৮',
                '9': '৯'
            };

            String.prototype.getDigitBanglaFromEnglish = function() {
                var retStr = this;
                for (var x in finalEnlishToBanglaNumber) {
                    retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
                }
                return retStr;
            };

            return bangla_converted_number = english_number.getDigitBanglaFromEnglish();

        },
        dateFormate: function(getDate) {
            const date = new Date(getDate)
            const dateTimeFormat = new Intl.DateTimeFormat('en', {
                year: 'numeric',
                month: 'short',
                day: '2-digit'
            })
            const [{
                value: month
            }, , {
                value: day
            }, , {
                value: year
            }] = dateTimeFormat.formatToParts(date)
            console.log(this.getBangla(day));
            return `${day}-${month}-${year }`;

            //console.log(`${day}-${month}-${year}`) // just for fun

        },
        dayName: function(dateString) {
            var days = ['রবি বার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
            var d = new Date(dateString);
            var dayName = days[d.getDay()];
            return dayName
        },
        getAppointment: function() {
            this.isLoaded = false;
            axios.get('api/reception.php?action=active')
                .then(function(response) {

                    app.gatepasses = response.data.result;
                    app.isLoaded = true;

                    console.log(response);
                    this.isLoading = false;
                    if (response.data.message === 'success') {
                        //this.user = response.data.user;
                        //app.user_loggedin=0
                        app.isLoaded = true;

                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        openModal: function() {
            this.isModalOpen = true;

        },
        closeModal: function() {
            this.isModalOpen = false;
        },

        editAppointment: function(contact, index) {
            this.formData = contact;
            this.isEditing = true;
            this.modalTitle = 'Edit';
            this.openModal();
        },
        changeAppointment: function() {
            app.ajaxloading=true;
            let formData = new FormData();
            //console.log("date:", this.formData.date, "id:", this.formData.id, " key:", this.formData.index)

            app.isLoaded = false;
            formData.append('id', this.formData.id || '')
            formData.append('action', 'save')
            formData.append('in_time', this.formData.in_time || '')
            formData.append('in_date', this.formData.in_date || '')
            formData.append('out_time', this.formData.out_time || '')
            formData.append('out_date', this.formData.out_date || '')
            formData.append('in_card', this.formData.in_card || '')
            formData.append('out_card', this.formData.out_card || '')
            formData.append('is_in', this.formData.is_in || '')
            formData.append('is_out', this.formData.is_out || '')
            formData.append('reception_comments', this.formData.reception_comments || '')
            var contact = {};
            formData.forEach(function(value, key) {
                contact[key] = value;
                //console.log(key);
            });

            axios({
                    method: 'post',
                    url: 'api/reception.php?action=active',
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                })
                .then(function(response) {
                    app.ajaxloading=false;
                    console.log(response)
                    app.closeModal(); // Vue.set(app.filteredGatepass, app.index, contact)
                    app.resetForm();
                    app.show('Data updated successfully.');
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

        },
        search_active: function(active) {
            this.showDisabled = (this.showDisabled === 1) ? 0 : 1;
            
            if(active=='active'){
                this.startRefresh=1;
                app.autoRefresh();
            }else{
                app.startRefresh=0;
                app.autoRefresh();
               
            }
            console.log(active)
            if(active==='previus'){
                        this.isPrevious=true;
            }else{
                this.isPrevious=false;
            }
            app.isLoaded = false;
            axios.get("api/reception.php?action="+active)
                .then(function(response) {
                    app.gatepasses = response.data.result;
                    app.isLoaded = true;

                    console.log(response);
                    this.isLoading = false;
                    if (response.data.message === 'success') {
                        //this.user = response.data.user;
                        //app.user_loggedin=0
                        app.isLoaded = true;
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
            
        },
        printpage() {
            window.print()
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
});
</script>

<style>
label {
    display: block;
    float: left;
    width: 100%;
    font-weight: bold;
}

#ajaxloading {
    display: none;
}
.modal-card-body label {
    text-align: center;
    padding: 0;
}
a.is-active {
    border-bottom: 1px solid red;
    background: red;
    color: #fff;
}
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  display: none;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #101010;
}

input:focus + .slider {
  box-shadow: 0 0 1px #101010;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
</body>

</html>