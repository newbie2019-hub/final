<template>
  <div class="sidenav">
   <div class="logo">
     <img src="@/assets/images/logo.svg" alt="">
   </div>
   <p class="text-center text-white fw-bolder">RESERVATION SYSTEM</p>
   <p class="text-center mb-5 text-white fw-bold"><small>{{Date.now() | moment}}</small></p>
   <router-link to="/dashboard/home" :class="getRoute == '/dashboard/event' || getRoute == '/dashboard/update' ? 'router-link-active' : ''"><i class="bi bi-bookmarks"></i> Home</router-link>
   <router-link to="/dashboard/reservation"><i class="bi bi-calendar2-week"></i> Reservations</router-link>
   <a href="" v-on:click.prevent="$bvModal.show('logoutModal')"><i class="bi bi-x-circle"></i> Log-out</a>

   <b-modal id="logoutModal" centered title="Logout">
    <p class="my-4">Are you sure you want to log-out?</p>
    <template #modal-footer = {cancel} >
      <b-button variant="primary" size="sm" @click="cancel()"> Cancel </b-button>
      <b-button size="sm" variant="danger" v-on:click.prevent="logout">
        Logout
      </b-button>
    </template>
   </b-modal>
  </div>
</template>
<script>
import moment from 'moment'
import { mapActions } from 'vuex';
export default {
  filters: {
     moment: function (date) {
      return moment(date).format('MMMM DD, YYYY');
    }
  },
  methods: {
   ...mapActions('auth', ['logoutUser']),
   async logout(){
     const res = await this.logoutUser()
     if(res.status == 200){
       this.$router.push('/')
     }
   }
  },
  computed: {
   getRoute: function(){
      return this.$route.path
    }
  }
}
</script>