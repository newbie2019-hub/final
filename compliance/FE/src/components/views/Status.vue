<template>
<div class="container" style="height: 100vh">
 <div class="p-3 pt-5">
   <div class="d-flex justify-content-between align-items-center">
    <div class="d-flex flex-column">
      <h5>
        {{user.first_name}} {{user.last_name}}
      </h5>
      <p class="text-muted">{{user.email}}</p>
    </div>
    <div class="d-flex">
      <a href="" class="btn btn-primary" v-on:click.prevent="$bvModal.show('logoutModal')">Logout</a>
    </div>
   </div>
   <div class="no-reservation" v-if="reservation_record == 0">
     <div >NO RESERVATIONS FOR THIS ACCOUNT</div>
   </div>
   <div class="mt-5" v-if="reservation_record != 0">
     <h5>RECORDS</h5>
     <h6 class="text-muted mb-4">Here are your records of recent transaction</h6>
     <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
       <div class="card p-5">
         <div class="table-responsive">
            <table class="table  table-striped table-hover">
              <thead>
                <tr>
                  <th >#</th>
                  <th >Event</th>
                  <th >Description</th>
                  <th >Rate</th>
                  <th >Day(s)</th>
                  <th >Start Date</th>
                  <th >End Date</th>
                  <th >Status</th>
                  <th >Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(record, i) in reservation_record" :key="i">
                  <th scope="row">{{i + 1}}</th>
                  <td>{{record.home.event.title}}</td>
                  <td>{{record.home.event.description}}</td>
                  <td>{{record.home.rate.rate}}</td>
                  <td>{{dateDifference(record)}}</td>
                  <td>{{record.start_date | moment}}</td>
                  <td>{{record.end_date | moment}}</td>
                  <td>{{record.status}}</td>
                  <td>{{record.home.rate.rate * dateDifference(record)}}</td>

                </tr>
              </tbody>
            </table>

         </div>
       </div>
     </div>
   </div>
 </div>
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
import moment from 'moment'
export default {
  filters: {
    moment: function (date) {
      return moment(date).format('MMMM Do YYYY, h:mm a');
    }
  },
  async mounted() {
    document.title="Check Account Status"
    await this.$store.dispatch('auth/checkAuthUser')
    await this.$store.dispatch('index/getReservations')
  },
  computed: {
    ...mapState('auth', ['user']),
    ...mapState('index', ['reservation_record']),
  },
  methods: {
   ...mapActions('auth', ['logoutAuthUser']),

   async logout(){
     const res = await this.logoutAuthUser()
     if(res.status == 200){
       this.$router.push('/')
     }
    },
    dateDifference(date){
        var start = moment(date.start_date, "YYYY-MM-DD")
        var end = moment(date.end_date, "YYYY-MM-DD").add(1, 'days')
        return moment.duration(end.diff(start)).asDays()
    },
  }
}
</script>