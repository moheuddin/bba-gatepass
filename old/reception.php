<?php include 'front-header.php';
if(strlen($_SESSION['alogin'])==0)
{	
    header('location:login/index.php');
}elseif(strlen($_SESSION['alogin'])>0){
    if($_SESSION['role'] != 'Reception'){
       echo '<h1 class="text-center"></h1>You have no access this page.</h1>';
    }
}
?>

<section class="section">
    <div class="container">
        <div v-cloak id="vue_appointment">
            <div class="row">
                <div class="col-md-6">
                    <app-component1></app-component1>
                </div>
                <div class="col-md-6">
                    <app-component2></app-component2>
                </div>
            </div>

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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <label for="in_date">Date</label>
                                            <flat-pickr v-model="formData.in_date" class="form-control"
                                                placeholder="Select Date" name="in_date">
                                            </flat-pickr>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <label class="label">Time</label>

                                            <flat-pickr v-model="formData.in_time" :config="config" class="form-control"
                                                placeholder="Select time" name="in_time">
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
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <label for="in_card">Card No IN</label>
                                            <input class="form-control" type="text" name="in_card"
                                                v-model="formData.in_card">

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="is_in">Is In</label>
                                        <input name="is_in" type="checkbox" v-model="formData.is_in" true-value="1"
                                            false-value="0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <label class="label">Date</label>
                                            <flat-pickr v-model="formData.in_date" class="form-control"
                                                placeholder="Select time" name="in_date">
                                            </flat-pickr>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <label class="label">Time</label>
                                            <div class="input-group">
                                                <flat-pickr v-model="formData.in_time" :config="config"
                                                    class="form-control" placeholder="Select time" name="in_time">
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
                                        <div class="input-group">
                                            <label for="card_out">Card Received</label>
                                            <input class="form-control" type="text" name="card_out"
                                                v-model="formData.card_out">

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="checkbox" class="checkbox-inline">Is Out
                                                <input type="checkbox" id="checkbox" v-model="formData.is_out"
                                                    true-value="1" false-value="0" />
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <label for="reception_comments">Comments</label>
                                            <input class="form-control" type="text" name="reception_comments"
                                                v-model="formData.reception_comments">
                                        </div>
                                    </div>
                                </div>
                        </section>

                        <div id="ajaxloading" style="background:#fff;display:block;text-align:center;"
                            v-if="isLoaded==false">
                            <div class="fa-3x text-center">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </div>

                        <footer class="modal-card-foot" style="justify-content: flex-end;">

                            <button v-if="isEditing" class="button is-primary" @click="changeAppointment()">
                                Save</button>
                        </footer>
                        </form>

                    </div>
                    <button class="modal-close is-large" aria-label="close" @click="closeModal()"></button>
                </div>

                <div class="tabs noprint">
                    <ul>
                        <li :class="{ 'is-active': !showDisabled }" @click="search_active('active')"><a>Active</a>
                        </li>
                        <li :class="{ 'is-active': showDisabled }" @click="search_active('inactive')">
                            <a>Previous</a>
                        </li>
                        <li>
                            <div class="noprint"><button @click="printpage">Printing</button< /div>
                        </li>
                    </ul>
                </div>

                <div id="print">
                    <div id="loader" v-if="isLoaded==false" class="fa-3x">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <table class="table is-striped is-hoverable" width="100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Visitor Name</th>
                                <th>E-Mail/Mobile</th>
                                <th>Card Issuer</th>
                                <th>Comments</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(contact, index) in contacts" :key="contact.id">
                                <td width="15">{{contact.date }} <br>{{dayName(contact.date)}}</td>
                                <td>{{ contact.time }}</td>
                                <td>{{ contact.visitor_name }}</td>
                                <td>
                                    {{ contact.mobile }}<br>
                                    {{ contact.email }}
                                </td>
                                <td>
                                    {{ contact.user_name }}<br>
                                    {{ contact.user_designation }}

                                </td>
                                <td>
                                    {{ contact.comments }} <br>
                                    Reception Comment:<br>
                                    {{contact.reception_comments}}

                                </td>

                                <td class="edit noprint">
                                    <span class="edit noprint" @click="editAppointment(contact, index)"><i
                                            class="fa fa-edit"></i></span>
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
    data: {
        showLogin: false,
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
        ajaxloading: false,
        contacts: [],
        formData: {
            date: '',
            time: '',
            visitor_name: '',
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
            index: '',
            issuer: '<?php echo $_SESSION['alogin'];?>'
        },
        time: null,
        timer: null,
        showDisabled: 0,
        isLoaded: false,
        isLoading: true,
        userName: '',
        isEditing: false,
        isModalOpen: false,
        modalTitle: 'Edit'
    },
    created: function() {
        this.isLoading = true;
        //this.getAppointment();
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

        this.timer = setInterval(() => {
            this.getAppointment();
        }, 30000);

    },
    computed: {

    },
    methods: {
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
            app.isLoaded = false;
            axios.get('api/reception.php')
                .then(function(response) {

                    app.contacts = response.data.result;
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
            formData.append('out_date', this.formData.out_date || '')
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
                    url: 'api/reception.php',
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                })
                .then(function(response) {
                    app.isLoaded = true;
                    console.log(response)
                    app.closeModal(); // Vue.set(app.filteredContacts, app.index, contact)
                    app.resetForm();
                })
                .finally(() => (this.loading = false)) //when the requests finish
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
        search_active: function(active) {
            this.showDisabled = (this.showDisabled === 1) ? 0 : 1;
            if (active) {
                app.isLoaded = false;
            axios.get('api/previous.php?previsou=1')
                .then(function(response) {

                    app.contacts = response.data.result;
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
            } else {
                app.getAppointment();
            }
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
</style>
</body>

</html>