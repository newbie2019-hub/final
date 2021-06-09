<template>
  <div>
    <div class="row w-100 p-3">
      <div class="card p-3">
      <h6 class="fw-bold"><small><i class="bi bi-calendar2-week"></i> Reservations</small></h6>
      </div>
      <div class="card p-5 mt-4">
        <div class="row justify-content-end align-items-center">
          <div class="col-4 col-md-4 col-lg-3 mb-3">
            <date-picker v-model="date" @change="filterReservation" type="date" class="mt-2" value-type="format" format="YYYY-MM-DD" range placeholder="Please select date"></date-picker>
          </div>
          <div class="col-4 col-md-4 col-lg-3 mb-3">
            <div class="mb-3">
              <label for="search" class="form-label">Find Reservation</label>
              <input type="text" class="form-control" v-model="search" id="search" placeholder="Search">
            </div>
          </div>
        </div>
        <div class="row justify-content-end align-items-center">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Day(s)</th>
                  <th scope="col">Start Date</th>
                  <th scope="col">End Date</th>
                  <th scope="col">Status</th>
                  <th scope="col">Total</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody v-if="reservations.length != 0">
                <tr v-for="(res, i) in searchReservation" :key="i">
                  <td>{{res.id}}</td>
                  <td>{{res.user.first_name}} {{res.user.last_name}}</td>
                  <td>{{res.user.email}}</td>
                  <td>{{dateDifference(res)}}</td> 
                  <td>{{res.start_date}}</td>
                  <td>{{res.end_date}}</td>
                  <td>{{res.status}}</td>
                  <td>{{res.home.rate.rate * dateDifference(res)}}</td>
                  <td>
                    <button v-b-tooltip.hover title="Paid Reservation" v-on:click.prevent="changeToPaid(res)"  :disabled="res.status == 'Paid'" href="" class="btn btn-sm btn-success me-2"><i class="bi bi-check2-all"></i></button>
                    <button v-b-tooltip.hover title="Cancel Reservation" href="" class="btn btn-sm btn-danger me-2" :disabled="res.status == 'Cancelled'" v-on:click.prevent="changeToCancelled(res)"><i class="bi bi-x-circle"></i></button>
                    <button v-b-tooltip.hover title="Delete Reservation" href="" class="btn btn-sm btn-danger" v-on:click.prevent="delReservation(res.id)"><i class="bi bi-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
            <p class="text-center mt-3" v-if="reservations == 0">No Reservations</p>
          </div>
        </div>
      </div>
     </div>
  </div>
</template>
<script>
import {mapState, mapActions} from 'vuex'
import moment from 'moment'
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
export default {
  data(){
    return {
      date: [
      ],
      search: '',
    }
  },
  async mounted() {
    this.getReservations()
  },
  components: {DatePicker},
  methods: {
    ...mapActions('home', ['getReservations', 'getFilteredReservation', 'setCancelledStatus', 'setPaidStatus', 'deleteReservation']),
    dateDifference(date){
        var start = moment(date.start_date, "YYYY-MM-DD")
        var end = moment(date.end_date, "YYYY-MM-DD").add(1, 'days')
        return moment.duration(end.diff(start)).asDays()
    },
    
    async filterReservation() {
      if(this.date.length == 0 || this.date[0] == null){
        return this.getReservations()
      }
      else {
        let data = {
          start_date: this.date[0],
          end_date: this.date[1]
        }
        const res = await this.getFilteredReservation(data)
        console.log(res)
      }
    },
    async changeToPaid(data){
      const res = await this.setPaidStatus(data.id)
      console.log(res)
      if(res.status == 200){
        this.getReservations()
      }
    },
    async changeToCancelled(data){
      const res = await this.setCancelledStatus(data.id)
      console.log(res)
      if(res.status == 200){
        this.getReservations()
      }
    },
    async delReservation(id){
      const res = await this.deleteReservation(id)
      if(res.status == 200){
        this.getReservations()
        this.$toast.success('Reservation record deleted successfully!')
      }
    }
  },
  computed: {
    ...mapState('home', ['reservations']),
    searchReservation() {
      return this.reservations.filter((reservations) => {
        return (
          reservations.user.first_name.match(this.search) ||
          reservations.user.last_name.match(this.search) ||
          reservations.start_date.match(this.search) ||
          reservations.end_date.match(this.search) ||
          reservations.status.match(this.search)
        );
      });
    },
  },

}
</script>