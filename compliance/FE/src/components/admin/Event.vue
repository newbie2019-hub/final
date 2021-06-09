<template>
  <div>
   <div class="row w-100 p-3">
    <div class="card p-3">
     <div class="d-flex flex-row">
      <p class="fw-bold text-muted" ><small><i class="bi bi-bookmarks"></i> Home /</small></p>
      <p class="fw-bold "><small><i class="bi bi-node-plus ms-2"></i> Add Event</small></p>
     </div>
    </div>
    <div class="card p-5 mt-4">
     <h5 class="mb-4 text-primary">Add your event</h5>
     <div class="col-lg-5 col-md-6 col-5">
      <div class="mb-3">
        <label for="title" class="form-label">Event Title</label>
        <input v-model="event.title" type="email" class="form-control" id="title" placeholder="">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Event Description</label>
        <textarea v-model="event.description" class="form-control" id="description" rows="3" ></textarea>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Image</label>
        <VueFileAgent
            ref="vueFileAgent"
            @select="filesSelected($event)"
            :multiple="false"
            :maxSize="'5MB'"
            :deletable="true"
            :accept="'image/*,'"
            :theme="'list'"
            @beforedelete="onBeforeDelete($event)"
            @delete="fileDeleted($event)"
            :errorText="{
              type: 'Invalid file type. Only image file is allowed',
              size: 'Image should not exceed 5MB in size',
            }"
            v-model="fileRecords"
          ></VueFileAgent>
      </div>
       <label for="rate" class="form-label">Rate</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">PHP</span>
        <input v-model="event.rate" type="text" class="form-control" placeholder="" aria-label="Rate" aria-describedby="basic-addon1">
      </div>
      <a href="" class="btn btn-sm btn-primary me-2 mt-2" v-on:click.prevent="save">Save Event</a>
      <router-link to="/dashboard/home" class="btn btn-sm btn-secondary mt-2">Cancel</router-link>
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
     fileRecords: [],
     fileRecordsForUpload: [],
     event: {
      title: '',
      description: '',
      rate: '',
      image: '',
     },
     token: '',
   }
  },
  methods: {
    ...mapActions('home', ['uploadEvent']),
   filesSelected: function(fileRecordsNewlySelected) {
      var validFileRecords = fileRecordsNewlySelected.filter(
        (fileRecord) => !fileRecord.error
      );
      this.fileRecordsForUpload = this.fileRecordsForUpload.concat(
        validFileRecords
      );
    },
    fileDeleted: function(fileRecord) {
      var i = this.fileRecordsForUpload.indexOf(fileRecord);
      if (i !== -1) {
        this.fileRecordsForUpload.splice(i, 1);
      }
    },
    onBeforeDelete: function(fileRecord) {
      var i = this.fileRecordsForUpload.indexOf(fileRecord);
      if (i !== -1) {
        this.fileRecordsForUpload.splice(i, 1);
        var k = this.fileRecords.indexOf(fileRecord);
        if (k !== -1) this.fileRecords.splice(k, 1);
      }
    },
    async save(){
      if (this.event.title == '') return this.$toast.error('Title is required');
      if (this.event.description == '') return this.$toast.error('Description is required');
      if (this.event.rate == '') return this.$toast.error('Rate is required');

      if (this.fileRecordsForUpload.length == 0) return this.$toast.error("An Image is required");
      
      const img = await this.$refs.vueFileAgent.upload(
         `http://127.0.0.1:8000/api/admin/uploadFeaturedImage?token=` + localStorage.getItem("auth"), 
         {'X-Requested-With' : 'XMLHttpRequest'}, this.fileRecordsForUpload
      );

      this.event.image = img[0].data

      const event = await this.uploadEvent(this.event);
      if (event.status == 200) {
        this.$router.push("/dashboard/home");
        this.$toast.success("Event saved successfully!");
      } else {
        this.$toast.error("Something went wrong");
      }
    },
  }
}
</script>