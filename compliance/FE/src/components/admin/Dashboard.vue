<template>
  <div>
   <Sidenav />
   <Navbar />
   <div class="content-container">
    <router-view name="home"/>
    <router-view name="event"/>
    <router-view name="reservation"/>
    <router-view name="update"/>
   </div>
  </div>
</template>
<script>
import Sidenav from './components/Sidenav.vue'
import Navbar from './components/Navbar.vue'
export default { 
  mounted() {
    document.title = 'Dashboard'
  },
  components: {Sidenav, Navbar}
}
</script>