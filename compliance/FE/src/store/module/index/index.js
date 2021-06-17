import API from '../../base'
export default ({
 namespaced: true,
 state: {
  result: '',
  events: '',
  reservation_record: [],
 },
 actions: {
  async checkReservation({commit}, data){
   const res = await API.post('/reservation/check', data).then(res => {

    return res;
  }).catch(err => {
   return err.response;
  })

    return res;
  },
  async getEvents({commit}){
   const res = await API.get('/reservation/events').then(res => {
     commit('SET_EVENTS', res.data)
     return res;
   }).catch(err => {
     return err.response;
   })

   return res;
 },
 async createReservation({commit}, data){
  const res = await API.post('/reservation/reserve', data).then(res => {
    return res;
  }).catch(err => {
    return err.response;
  })

  return res; 
 },
 async getReservations({commit}){
  const res = await API.get('user/reservations').then(res => {
    commit('SET_RESERVATION_RECORD', res.data)
    return res;
  }).catch(err => {
    return err.response;
  })

  return res; 
 }
 
 },
 mutations: {
  SET_RESERVATION_DATA(state, data){
   state.result = data
  },
  SET_EVENTS(state, data){
   state.events = data
  },
  SET_RESERVATION_RECORD(state, data){
    state.reservation_record = data.data
  }
  
 },
 getters: {

 }
})