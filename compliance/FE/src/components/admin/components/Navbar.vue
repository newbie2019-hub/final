<template>
  <div>
   <div class="navigation">
    <avatar v-if="user" class=" mr-4" :username="user.first_name + ' ' + user.last_name" :rounded="true" :size="40" :color="'#fff'" :lighten="100"></avatar>
    <p class="text-dark username" v-if="user">Welcome, {{user.first_name}} {{user.last_name}}!</p>
   </div>
  </div>
</template>
<script>
import Avatar from 'vue-avatar' 
import { mapState, mapActions } from 'vuex'
export default {
  components: {
    Avatar
  },
  async mounted(){
    await this.checkUser()
  },
  computed: {
    ...mapState("auth", ["user"])
  },
  methods: {
   ...mapActions('auth', ['checkUser'])
  }
}
</script>