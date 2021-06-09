<template>
  <div>
    <div class="hero">
      <div class="index-navigation" :class="scrollpx >= 250 ? 'scrolled' : ''">
        <a href="#ourservice"><i class="bi bi-lightning-charge"></i> Services</a>
        <a href="#gallery"><i class="bi bi-images"></i> Gallery</a>
        <a href="#reservation"><i class="bi bi-calendar2-check"></i> Reservation</a>
        <a href="/status" v-if="hasUser" ><i class="bi bi-person-circle"></i> Account</a>
      </div>
      <div class="hero-content">
        <h6 class="mb-2 fw-bold">LNU HRDC HALL</h6>
        <p class="quote">CREATE MOMENTS THAT LAST A LIFETIME</p>
        <p class="quote-2">A perfect place where history rest and indeed a sanctuary 
          for moments like weddings, birthdays, and debut, graduations, 
          and many more</p>
          <a href="#ourservice" class="btn btn-outline-light rounded-pill mt-4">Learn More</a>
      </div>
    </div>
    <div class="container p-4" id="ourservice">
      <div class="row justify-content-center mt-5">
        <h4 class="text-center">OUR SERVICES</h4>
        <p class="text-center text-muted  mb-4">We offer what our customer needs</p>
        <div class="row align-items-center no-gutters mb-4 ">
          <div class="col-xl-6 col-lg-6 pt-3">
              <img class="img-fluid mb-3 mb-lg-0" src="@/assets/images/bg-hero.jpg" loading="lazy" />
          </div>
          <div class="col-xl-6 col-lg-6">
            <div class="service-spacing">
              <h4 class="service-title"> 18th Debut</h4>
              <p class="service-description">Lorem ipsum dolor sit amet, consectetur
                 adipisicing elit. Quia quos officiis consequatur repudiandae 
                 molestiae laborum voluptatum, doloribus est consectetur 
                 voluptas nam facilis. Repudiandae illo sed tenetur eligendi 
                 harum ullam itaque?</p>
            </div>
          </div>
        </div>
        <div class="row align-items-center no-gutters column-reverse mb-4 mt-3 ">
          <div class="col-xl-6 col-lg-6">
            <div class="service-spacing">
              <h4 class="service-title"> Graduation</h4>
              <p class="service-description">Lorem ipsum dolor sit amet, consectetur
                 adipisicing elit. Quia quos officiis consequatur repudiandae 
                 molestiae laborum voluptatum, doloribus est consectetur 
                 voluptas nam facilis. Repudiandae illo sed tenetur eligendi 
                 harum ullam itaque?</p>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 pt-3">
              <img class="img-fluid mb-3 mb-lg-0" src="@/assets/images/graduation.jpeg" loading="lazy" />
          </div>
        </div>
        <div class="row align-items-center no-gutters mb-4 mt-3">
          <div class="col-xl-6 col-lg-6 pt-3">
              <img class="img-fluid mb-3 mb-lg-0" src="@/assets/images/seminar.jpg" loading="lazy" />
          </div>
          <div class="col-xl-6 col-lg-6">
            <div class="service-spacing">
              <h4 class="service-title"> Seminars</h4>
              <p class="service-description">Lorem ipsum dolor sit amet, consectetur
                 adipisicing elit. Quia quos officiis consequatur repudiandae 
                 molestiae laborum voluptatum, doloribus est consectetur 
                 voluptas nam facilis. Repudiandae illo sed tenetur eligendi 
                 harum ullam itaque?</p>
            </div>
          </div>
        </div>
        <div class="row align-items-center no-gutters column-reverse mb-4 mt-3 ">
          <div class="col-xl-6 col-lg-6">
            <div class="service-spacing">
              <h4 class="service-title"> Weddings</h4>
              <p class="service-description">Lorem ipsum dolor sit amet, consectetur
                 adipisicing elit. Quia quos officiis consequatur repudiandae 
                 molestiae laborum voluptatum, doloribus est consectetur 
                 voluptas nam facilis. Repudiandae illo sed tenetur eligendi 
                 harum ullam itaque?</p>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 pt-3">
              <img class="img-fluid mb-3 mb-lg-0" src="@/assets/images/wedding.jpg" loading="lazy" />
          </div>
        </div>
      </div>
    </div>

     <div id="reservation" class="reservation p-5">
      <h4 class="text-center">Make a Reservation</h4>
      <p class="text-center text-muted">We keep adding touches to keep it a special event.</p>
      <div class="row w-100 justify-content-center align-items-center mt-5">
        <h5 class="text-center mb-3">Reservation Date</h5>
        <div class="col-10 col-md-5 col-lg-4 col-xl-3">
         <date-picker @change="available = false; clicked = false" v-model="date" type="date" class="mt-2" :disabled-date="disabledBeforeToday" value-type="format" format="YYYY-MM-DD" range placeholder="Please select date"></date-picker>
        </div>
        <div class="col-3 col-md-4 col-lg-3 col-xl-2 mt-2">
          <a v-on:click.prevent="check" class="btn btn-sm btn-primary"><i class="bi bi-calendar2-minus"></i> Check Availability </a>
        </div>
      </div>
      <div class="row w-100 justify-content-center align-items-center mt-5">
        <h5 class="text-center">Select Event</h5>
        <p class="text-muted text-center">Click the card to select an event</p>
        <div class="row justify-content-center align-items-center no-gutters mb-4 mt-3">
          <div v-for="(event, i) in events" :key="i" class="col-lg-4 col-xl-3 col-md-6 col-sm-6 text-white">
            <b-card :title="event.event.title" overlay
            :img-src="'http://127.0.0.1:8000/uploads/' + event.gallery.image" img-alt="Image" tag="article"
            class="mb-2 brightness-50 event-card" :id="'card-' + event.event.title" @click="checkPressed(event)" 
            :class="active_state == event.id ? 'event-selected' : ''">
              <b-card-text class="mt-3">
                {{event.event.description}}
              </b-card-text>
              <b-card-text class="mb-3 mt-3">
                Price: {{ formatCurrency(event.rate.rate)}}
              </b-card-text>
            </b-card>
          </div>
        </div>
      </div>
      <div class="row justify-content-center w-100 mt-3 mb-4" v-if="event.length != 0">
        <h4 class="text-center ">Reservation Info</h4>
        <h5 class="text-center mt-3">{{event.event.title}}</h5>
        <h6 class="text-center ">{{event.event.description}}</h6>
        <h6 class="text-center ">{{formatCurrency(event.rate.rate)}}</h6>
        <h6 class="text-center" v-if="date.length != 0 && date[0] != null">
            Number of Days: {{dateDifference()}}
        </h6>
      </div>
      <div class="row justify-content-center">
        <a href="" class="btn btn-sm btn-primary" v-on:click.prevent="reserve">Make Reservation</a>
      </div>
    </div>

    <div id="gallery" class="container mt-5 mb-5">
      <h5 class="text-center mt-4">Gallery</h5>
      <p class="text-center text-muted mb-4">We remember moments rather than dates</p>
      <div class="d-flex justify-content-center">
        <b-carousel id="carousel-no-animation" style="text-shadow: 0px 0px 2px #000" no-animation indicators img-width="1024" img-height="480">
            <b-carousel-slide
              caption="First slide"
              img-src="https://picsum.photos/1024/480/?image=10"></b-carousel-slide>
            <b-carousel-slide
              caption="Second Slide"
              img-src="https://picsum.photos/1024/480/?image=12"></b-carousel-slide>
            <b-carousel-slide
              caption="Third Slide"
              img-src="https://picsum.photos/1024/480/?image=22"></b-carousel-slide>
            <b-carousel-slide
              caption="Fourth Slide"
              img-src="https://picsum.photos/1024/480/?image=23"></b-carousel-slide>
          </b-carousel>
      </div>
    </div>

    <div class="footer">
      <h6 class="fw-bold mb-3 mt-3">GET IN TOUCH</h6>
      <div class="icons">
        <i class="bi bi-facebook footer-icons" ></i>
        <i class="bi bi-twitter footer-icons"></i>
        <i class="bi bi-instagram footer-icons"></i>
      </div>
      <p class="text-muted mt-3"><small>© 2020-2021, Tacloban City</small></p>
      <p class="text-muted"><small>Leyte Normal University</small></p>
      <p class="text-muted mb-3"><small>Austin Rille Picardal</small></p>
    </div>
   
    <!-- SIGNUP MODAL -->
    <b-modal id="signupModal" scrollable centered title="Create Account" no-close-on-esc no-close-on-backdrop style="z-index: 99999">
      <div class="pe-5 ps-5">
        <p>Create an account first to proceed for reservation</p>
      </div>
      <form class="pe-5 ps-5 pt-4">
        <div class="form-group">
          <label for="firstname">First Name</label>
          <input v-model="user_data.first_name" type="text"  class="form-control" id="firstname" placeholder="" />
        </div>
        <div class="form-group mt-2">
          <label for="middlename">Middle Name</label>
          <input v-model="user_data.middle_name" type="text" class="form-control" id="middlename" placeholder="" />
        </div>
        <div class="form-group mt-2">
          <label for="lastname">Last Name</label>
          <input v-model="user_data.last_name" class="form-control" id="lastname" placeholder="" type="text"/>
        </div>
        <div class="form-group mt-2">
          <label for="email">Email</label>
          <input v-model="user_data.email"  class="form-control" id="email" placeholder="" type="email"/>
        </div>
        <div class="form-group mt-2">
          <label for="password">Password</label>
          <input  v-model="user_data.password" class="form-control" id="password" placeholder="" type="password"/>
        </div>
      </form>
      <template #modal-footer>
        <a href="" class="btn btn-sm btn-primary" v-on:click.prevent="login" >
          Sign-in
        </a>
        <b-button size="sm" variant="primary" v-on:click.prevent="signup" >
          Proceed
        </b-button>
      </template>
    </b-modal>

    <b-modal id="reservationSuccess" scrollable centered title="Reservation Successful" no-close-on-esc no-close-on-backdrop style="z-index: 99999">
      <p>You can now proceed to Leyte Normal University for the settlement of your payment.Sign-in to your account to view or add a transaction</p>
      <template #modal-footer="{ cancel }">
        <b-button size="sm" variant="primary" @click="cancel">
          Got it
        </b-button>
      </template>
    </b-modal>

  </div>
</template>
<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import { mapState, mapActions } from 'vuex'
import moment from 'moment'
export default {
  data() {
    return {
      date: [],
      scrollpx: 0,
      active_state: '',
      available: false,
      clicked: false,
      user_data: {
        first_name: '',
        middle_name: '',
        last_name: '',
        email: '',
        password: '',
      },
      event: [],
      hasUser: false,
    }
  },
  components: { DatePicker },
  computed: {
    ...mapState('index', ['events', 'result', 'user']),
    ...mapState('auth', ['user'])
  },
  async mounted() {
    document.title = "Event Reservation for Leyte Normal University HRDC Hall"
    await this.getEvents()
    const res = await this.checkAuthUser()
    this.hasUser = res.status == 401 ? false : true 
  },
  created() {
    window.addEventListener('scroll', this.handleScroll);
  },
  destroyed() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    ...mapActions('index', ['checkReservation', 'getEvents', 'createReservation']),
    ...mapActions('auth', ['createAccount', 'checkAuthUser',]),
    handleScroll() {
      this.scrollpx = window.scrollY;
    },
    async check() {
      if(this.date.length == 0 || this.date[0] == null) return this.$toast.error('Please select a date first')
      this.available = false

      this.clicked = false
      let data = {
        start_date: this.date[0],
        end_date: this.date[1]
      }

      this.clicked = true
      const res = await this.checkReservation(data)
      
      if(res.data.data == 'No results found'){
        this.available = true
        return this.$toast.success('Selected dates are available for reservation')
      }
      else 
      {
        return this.$toast.error('Selected dates are not available for reservation')
      }
    },
    async login(){
      let data = {
        home_id: this.event.id,
        start_date: this.date[0],
        end_date: this.date[1]
      }
      
      this.$store.commit('home/SET_DATA', data)
      this.$router.push('/login')
    },
    formatCurrency(data){
      var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',
      });

      return formatter.format(data);
    },
    checkPressed(event){
      this.active_state = event.id
      this.event = event
    },
    async reserve(){
      if(this.date.length == 0) return this.$toast.error('You haven\'t selected and checked for the dates yet')
      if(!this.clicked) return this.$toast.error('Please click the check availability button after selecting the dates')
      if(!this.available) return this.$toast.error('Selected date(s) not available')
      if(this.active_state == '') return this.$toast.error('Please select type of event')

      if(this.user == '' || this.user == undefined){
        this.$bvModal.show('signupModal')
      }
      else {
        console.log(this.user)
        await this.storeReservation(this.user.id)
      }

    },
    disabledBeforeToday(date){
      let d = new Date()
      d.setDate(d.getDate() + 1)
      return date < new Date(d.setHours(0, 0, 0, 0));
    },
    async signup(){
      if(!this.isEmailValid()) {
        return this.$toast.error('Email is invalid')
      }
      const res = await this.createAccount(this.user_data)
      if(res.status == 200){
        this.storeReservation(res.data.user_id)
      }
      else
      {
        this.validationError(res.data)
      }
    },
    async storeReservation(userid){
      let data = {
        user_id: userid,
        home_id: this.event.id,
        start_date: this.date[0],
        end_date: this.date[1]
      }
      
      const res = await this.createReservation(data)
      if(res.status == 200){
        this.$bvModal.hide('signupModal')
        this.$toast.success('Reservation successful');
        this.$bvModal.show('reservationSuccess')
        this.date = []
        this.available = false
        this.clicked = false
      }
    },
    dateDifference(){
      var start = moment(this.date[0], "YYYY-MM-DD");
      var end = moment(this.date[1], "YYYY-MM-DD").add(1, 'days');
      return moment.duration(end.diff(start)).asDays() + " Day(s)"
    },
    validationError(data){
      for (const key of Object.keys(data)) {
        window.setInterval(this.$toast.error(data[key][0]), 1000); 
      }
    },
    isEmailValid(){
      let regEx = /^([a-z0-9_\-.])+@([a-z0-9_\-.])+\.([a-z0-9]{2,})$/gi
      let isEmail = regEx.test(this.user.email)
      return isEmail
    },
  },
  
}
</script>
