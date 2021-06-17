import API from '../../base/'

export default {
  namespaced: true,
  state: {
    user: [],
    token: localStorage.getItem('auth') || ''
  },
  getters: {
    GET_USER(state) {
      return state.user;
    }
  },
  mutations: {
    SET_AUTH_ACC(state, data) {
      state.user = data

    },
    SET_ACC(state, data){
      state.user = data
      const bearer_token = localStorage.getItem('auth') || ''
      API.defaults.headers.common['Authorization'] = `Bearer ${bearer_token}`
    },
    SET_USER_ACC(state, data) {
      state.user = data
      const bearer_token = localStorage.getItem('auth') || ''
      API.defaults.headers.common['Authorization'] = `Bearer ${bearer_token}`
    },
    SET_USER_TOKEN(state, token) {
     localStorage.setItem('auth', token)
     localStorage.setItem('isUser', 'true')
     state.token = token

     const bearer_token = localStorage.getItem('auth') || ''
     API.defaults.headers.common['Authorization'] = `Bearer ${bearer_token}`
    },
    SET_AUTH_TOKEN(state, token) {
     localStorage.setItem('auth', token)
     localStorage.setItem('isAdmin', 'true')
     state.token = token

     const bearer_token = localStorage.getItem('auth') || ''
     API.defaults.headers.common['Authorization'] = `Bearer ${bearer_token}`
    },
    UNSET_USER(state){
     localStorage.removeItem('auth');
     localStorage.removeItem('isUser');
     localStorage.removeItem('isAdmin');
     state.token = ''
     state.user = ''

     API.defaults.headers.common['Authorization'] = ''
   } 
  },
  actions: {
    async loginAccount({commit}, payload){
      const res = await API.post('/auth/admin/login', payload).then(res => {
        commit('SET_AUTH_ACC', res.data.user)
        commit('SET_AUTH_TOKEN', res.data.access_token)

        return res;
      }).catch(err => {
       return err.response;
      })

      return res;
    },
    async loginUserAccount({commit}, payload){
      const res = await API.post('/auth/user/login', payload).then(res => {
        commit('SET_USER_ACC', res.data.user)
        commit('SET_USER_TOKEN', res.data.access_token)

        return res;
      }).catch(err => {
       return err.response;
      })

      return res;
    },
    async createAccount({commit}, payload){
      const res = await API.post('/auth/user/store', payload).then(res => {

        return res;
      }).catch(err => {
       return err.response;
      })

      return res;
    },
    async updateAccount({commit}, payload){
      const res = await API.put('auth/update', payload).then(res => {
        return res;
      }).catch(err => {
       return err.response;
      })

      return res;
    },
    async logoutUser({commit}){
     const res = await API.post('auth/admin/logout?token=' + localStorage.getItem('auth')).then(response => {
       commit('UNSET_USER')
       return response
     }).catch(error => {
       return error.response
     });

     return res;
   },
    async logoutAuthUser({commit}){
     const res = await API.post('auth/user/logout?token=' + localStorage.getItem('auth')).then(response => {
       commit('UNSET_USER')
       return response
     }).catch(error => {
       return error.response
     });

     return res;
   },
   async checkUser({commit}) {
    const res = await API.post('auth/admin/me?token=' + localStorage.getItem('auth')).then(res => {
      commit('SET_ACC', res.data)
      return res;
    }).catch(error => {
      return error.response;
    })

    return res;
   },
   async checkAuthUser({commit}) {
    const res = await API.post('auth/user/me?token=' + localStorage.getItem('auth')).then(res => {
      commit('SET_USER_ACC', res.data)

      return res;
    }).catch(error => {
      return error.response;
    })

    return res;
   },
  },
}