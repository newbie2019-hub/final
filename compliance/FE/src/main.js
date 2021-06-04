import Vue from 'vue'
import store from './store'
import App from './App.vue'
import router from './router'
import './assets/css/style.css'
import Toast from "vue-toastification";
import 'bootstrap/dist/css/bootstrap.css'
import "vue-toastification/dist/index.css";
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 4,
});

new Vue({
  router, store,
  render: h => h(App)
}).$mount('#app')
