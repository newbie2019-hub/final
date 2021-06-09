import Vue from 'vue'
import store from './store'
import App from './App.vue'
import router from './router'
import Toast from "vue-toastification";
import VueFileAgent from 'vue-file-agent';
import { BootstrapVue, IconsPlugin, CarouselPlugin } from 'bootstrap-vue'
import './assets/css/style.css'
import 'bootstrap/dist/css/bootstrap.css'
import "vue-toastification/dist/index.css";
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'vue-file-agent/dist/vue-file-agent.css';
import 'bootstrap-icons/font/bootstrap-icons.css'

Vue.use(CarouselPlugin)
Vue.use(VueFileAgent);
Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 4,
  position: "top-right",
  hideProgressBar: true,
});

new Vue({
  router, store,
  render: h => h(App)
}).$mount('#app')
