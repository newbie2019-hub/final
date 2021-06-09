import API from '../../base'
export default ({
 namespaced: true,
 state: {
  events: '',
  event_update: '',
  reservations: '',
  reserve_data: ''
 },
 actions: {
  async uploadEvent({commit}, data){
   const res = await API.post('/admin/store', data).then(res => {
      return res;
   }).catch(err => {
      return err.response;
   })

    return res;
  },
  async getEvents({commit}){
    const res = await API.get('/admin/events').then(res => {
      commit('SET_EVENTS', res.data)
      return res;
    }).catch(err => {
      return err.response;
    })

    return res;
  },
  async setPaidStatus({commit}, id){
    const res = await API.put('/admin/reservation/paid/' + id).then(res => {
      return res;
    }).catch(err => {
      return err.response
    })

    return res
  },
  async setCancelledStatus({commit}, id){
    const res = await API.put('/admin/reservation/cancelled/' + id).then(res => {
      return res;
    }).catch(err => {
      return err.response
    })

    return res
  },
  async getReservations({commit}){
    const res = await API.get('/admin/reservation').then(res => {
      commit('SET_RESERVATIONS', res.data)
      return res;
    }).catch(err => {
      return err.response;
    })

    return res;
  },
  async getFilteredReservation({commit}, data){
    const res = await API.post('/admin/filter/reservation', data).then(res => {
      commit('SET_RESERVATIONS', res.data)
      return res;
    }).catch(err => {
      return err.response;
    })

    return res;
  },
  async deleteEvent({commit}, data){
    const res = await API.delete('/admin/events/' + data).then(res => {
      return res;
    }).catch(err => {
      return err.response;
    })
    return res;
  },
  async deleteReservation({commit}, data){
    const res = await API.delete('/admin/reservation/' + data).then(res => {
      return res;
    }).catch(err => {
      return err.response;
    })
    return res;
  },
  async updateEvent({commit}, {id, data}){
    const res = await API.put('/admin/events/' + id, data).then(res => {
      return res;
    }).catch(err => {
      return err.response;
    })
    return res;
  },
 },
 mutations: {
  SET_EVENTS(state, data){
   state.events = data
  },
  SET_UPDATE(state, data){
   state.event_update = data
  },
  SET_RESERVATIONS(state, data){
   state.reservations = data
  },
  SET_DATA(state, data){
   state.reserve_data = data
  },
 },
 getters: {

 }
})