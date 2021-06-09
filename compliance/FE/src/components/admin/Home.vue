<template>
  <div>
   <div class="row w-100 p-3">
    <div class="card p-3">
     <h6 class="fw-bold"><small><i class="bi bi-bookmarks"></i> Home</small></h6>
    </div>
    <div class="card p-5 mt-4">
     <div class="row justify-content-end align-items-center">
      <div class="col-4 col-md-3 col-lg-4 d-flex flex-row justify-content-end">
       <router-link to="/dashboard/event" class="btn btn-primary btn-sm">Add Event</router-link>
      </div>
      <div class="col-4 col-md-4 col-lg-3 mb-3">
       <div class="mb-3">
         <label for="search" class="form-label">Find Event</label>
         <input type="text" class="form-control" id="search" placeholder="Search">
       </div>
      </div>
     </div>
     <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Rate</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(event, i) in events" :key="i">
            <th>{{event.id}}</th>
            <th><img :src="'http://127.0.0.1:8000/uploads/'+ event.gallery.image" alt="" class="img-fluid" height="120" width="120"></th>
            <td>{{event.event.title}}</td>
            <td>{{event.event.description}}</td>
            <td>{{ formatCurrency(event.rate.rate)}}</td>
            <td>
              <a href="" class="btn btn-sm btn-primary me-2" v-on:click.prevent="update(event)">Update</a>
              <a href="" class="btn btn-sm btn-danger" v-on:click.prevent="$bvModal.show('deleteModal'); data = event">Delete</a>
            </td>
          </tr>
        </tbody>
      </table>
      <p class="text-center mt-3" v-if="events == 0">No Events Added</p>
     </div>
    </div>
   </div>

   <b-modal id="deleteModal" centered title="Confirm Delete">
    <p class="my-4">Are you sure you want to delete this event?</p>
    <template #modal-footer = {cancel} >
      <b-button variant="primary" size="sm" @click="cancel()"> Cancel </b-button>
      <b-button size="sm" variant="danger" v-on:click.prevent="remove">
        Delete
      </b-button>
    </template>
   </b-modal>
  </div>
</template>
<script>
import {mapActions, mapState} from 'vuex'
export default {
  data() {
    return {
      data: {
        id: '',
        description: '',
        title: '',
        rate: '',
        image: '',
      }
    }
  },
  async mounted() {
    await this.getEvents()
  },
  methods: {
    ...mapActions('home', ['getEvents', 'deleteEvent']),
    formatCurrency(data){
      var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',
      });

      return formatter.format(data);
    },
    async remove(){
      const res = await this.deleteEvent(this.data.id)
      if(res.status == 200){
        this.$bvModal.hide('deleteModal')
        await this.getEvents()
        this.$toast.success('Event deleted successfully!');
      }
    },
    async update(data){
      this.data.id = data.id
      this.data.description = data.event.description
      this.data.title = data.event.title
      this.data.image = data.gallery.image
      this.data.rate = data.rate.rate

      this.$store.commit('home/SET_UPDATE', this.data)
      this.$router.push('update')
    } 
   
  },
  computed: {
    ...mapState('home', ['events'])
  }
}
</script>