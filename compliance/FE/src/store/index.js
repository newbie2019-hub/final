import Vue from 'vue'
import Vuex from 'vuex'

import home from './module/home'
import auth from './module/auth'
import index from './module/index'

Vue.use(Vuex);

export default new Vuex.Store({
 modules: {
  home, auth, index
 }
})

