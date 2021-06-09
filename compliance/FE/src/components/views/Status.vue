<template>
 <div>
   <h5>Hello</h5>
   <a href="" v-on:click.prevent="$bvModal.show('logoutModal')">Logout</a>
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
import {mapState, mapActions} from 'vuex'
export default {
  methods: {
   ...mapActions('auth', ['logoutAuthUser']),
   async logout(){
     const res = await this.logoutAuthUser()
     if(res.status == 200){
       this.$router.push('/')
     }
    },
  }
}
</script>