
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Login Form | Vue</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div id="app">

   <div class="login-page">
      <transition name="fade">
         <div v-if="!registerActive" class="wallpaper-login"></div>
      </transition>
      <div class="wallpaper-register"></div>

      <div class="container">
         <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8 mx-auto">
               <div v-if="!registerActive" class="card login" v-bind:class="{ error: emptyFields }">
                  <h1>Sign In</h1>
                  <form class="form-group">
                     <input v-model="formData.email" type="text" class="form-control" placeholder="Email" required>
                     <input v-model="formData.password" type="password" class="form-control" placeholder="Password" required>
                     <input type="submit" class="btn btn-primary" @click="doLogin">
                     <input type="submit" class="btn btn-primary" @click="checkAuthentication">
                     <p>Don't have an account? <a href="#" @click="registerActive = !registerActive, emptyFields = false">Sign up here</a>
                     </p>
                     <p><a href="#">Forgot your password?</a></p>
                  </form>
               </div>

               <div v-else class="card register" v-bind:class="{ error: emptyFields }">
                  <h1>Sign Up</h1>
                  <form class="form-group">
                     <input v-model="emailReg" type="email" class="form-control" placeholder="Email" required>
                     <input v-model="passwordReg" type="password" class="form-control" placeholder="Password" required>
                     <input v-model="confirmReg" type="password" class="form-control" placeholder="Confirm Password" required>
                     <input type="submit" class="btn btn-primary" @click="doRegister">
                     <p>Already have an account? <a href="#" @click="registerActive = !registerActive, emptyFields = false">Sign in here</a>
                     </p>
                  </form>
               </div>
            </div>
         </div>

      </div>
   </div>

</div>
<!-- partial -->
  <script src="assets/js/vue.js"></script>
<script src="assets/js/axios.min.js"></script>
  </script>
  <script>
  var app = new Vue({
  el: "#app",

  data: {
    registerActive: false,
    emailLogin: "",
    passwordLogin: "",
    emailReg: "",
    passwordReg: "",
    confirmReg: "",
    emptyFields: false ,
    formData: {
            email: '',
            password: ''
        }
   },


  methods: {
    doLogin() {
  
         console.log('start')
         let formData = new FormData();
            formData.append('email', this.formData.email || '')
            formData.append('password', this.formData.password || '')

            axios({
                    method: 'post',
                    url: 'auth/login.php',
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                })
                .then(function(response) {
                    console.log(response)
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });


    },
    checkAuthentication(){
      var token="";
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      let formData = new FormData();
      formData.append('email', this.formData.email || '')

      axios({
                    method: 'post',
                    url: 'auth/protected.php',
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                })
                .then(function(response) {
                    console.log(response)
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
    },

    doRegister() {
      if (this.emailReg === "" || this.passwordReg === "" || this.confirmReg === "") {
        this.emptyFields = true;
      } else {
        alert("You are now registered");
      }
    } } });
  </script>
<style>
p {
  line-height: 1rem;
}

.card {
  padding: 20px;
}

.form-group input {
  margin-bottom: 20px;
}

.login-page {
  align-items: center;
  display: flex;
  height: 100vh;
}

.login-page .fade-enter-active,
.login-page .fade-leave-active {
  transition: opacity 0.5s;
}
.login-page .fade-enter,
.login-page .fade-leave-to {
  opacity: 0;
}

.login-page h1 {
  margin-bottom: 1.5rem;
}

.error {
  animation-name: errorShake;
  animation-duration: 0.3s;
}

@keyframes errorShake {
  0% {
    transform: translateX(-25px);
  }
  25% {
    transform: translateX(25px);
  }
  50% {
    transform: translateX(-25px);
  }
  75% {
    transform: translateX(25px);
  }
  100% {
    transform: translateX(0);
  }
}
</style>
</body>
</html>
