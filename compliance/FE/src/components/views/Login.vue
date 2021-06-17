<template>
  <div>
    <div class="hero ">
     <div class="d-flex justify-content-center align-items-center h-100">
      <div class="col-8 col-sm-6 col-md-5 col-lg-3">
       <div class="card p-5">

         <h4 class="mb-3 mt-2">Login</h4>
         <p class="mb-4"><small>Welcome! Please fill in your email and password to sign-in.</small></p>
         <div class="form-floating mb-3">
          <input v-model="data.email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Email address</label>
         </div>
         <div class="form-floating">
            <input v-model="data.password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
         </div>         
         <div class="form-check mt-2">
           <input v-model="adminlogin" type="checkbox" class="form-check-input" id="adminlogin">
           <label class="form-check-label"  for="adminlogin"><small>Admin login</small></label>
         </div>
         <div class="d-flex justify-content-center mt-4">
          <div class="col-12">
           <a href="" v-on:click.prevent="login" class="btn btn-primary btn-100">Login <i class="bi bi-arrow-right-circle"></i></a>
          </div>
         </div>
       </div>
      </div>
     </div>
    </div>
    
  </div>
</template>
<script>
import {mapActions} from 'vuex'
export default {
  data() {
    return {
      data: {
        email: '',
        password: ''
      },
      adminlogin: false,
    }
  },
  mounted() {
   document.title ="Please Login"
  },
  methods: {
    ...mapActions('auth', ['loginAccount', 'loginUserAccount']),
    async login(){
      if(this.adminlogin){
        await this.loginAccount(this.data).then(res => {
          if(res.status == 200)
          {
            this.$toast.success('Welcome, User!');
            this.$router.push('/dashboard/home');
          }
          else 
          {
            this.$toast.error('Invalid Credentials')
          }
        })
      }
      else {
        await this.loginUserAccount(this.data).then(res => {
        if(res.status == 200)
        {
          this.$router.push('/');
        }
        else 
        {
          this.$toast.error('Invalid Credentials')
        }
      }) 
      }

    }
  }
}
</script>
<style scoped>
.hero {
 height: 100vh;
 background: linear-gradient(to right, rgba(49, 49, 49, 0.404), rgba(0, 0, 0, 0.644)), url('~@/assets/images/bg-hero.jpg');
 background-attachment: fixed;
 background-repeat: no-repeat;
 background-size: cover;
 position: absolute;
 width: 100%;
}

.form-control:focus {
 box-shadow: 0 0 0 0.1rem rgb(13 110 253 / 25%) !important;
}

.register-button {
 position: absolute;
 right: 12%;
 top: 5%;
}

.btn-register {
 color: black;
 border-bottom: 0px solid #000;
 transition: all 250ms ease;
}

.btn-register:hover {
 color: rgb(55, 137, 214);
 
}


</style>