import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from '../components/views/Login'
import Home from '../components/admin/Home'
import Reservation from '../components/admin/Reservation'
import EventUpdate from '../components/admin/EventUpdate'
import Event from '../components/admin/Event'
import Status from '../components/views/Status'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {
      hasUser: true
    }
  },
  {
    path: '/status',
    name: 'Status',
    component: Status,
    meta: {
      notAdmin: true,
    }
  },
  {
    path: '/',
    name: 'Index',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../components/views/Index.vue')
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    meta: {requiresLogin: true, isAdmin: true},
    component: () => import(/* webpackChunkName: "dashboard" */ '../components/admin/Dashboard.vue'),
    children: [
      {
        path: 'home',
        name: 'home',
        components: {
          home: Home
        }
      },
      {
        path: 'event',
        name: 'event',
        components: {
          event: Event
        }
      },
      {
        path: 'reservation',
        name: 'reservation',
        components: {
          reservation: Reservation
        }
      },
      {
        path: 'update',
        name: 'update',
        components: {
          update: EventUpdate
        }
      },
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
	if (to.matched.some((record) => record.meta.requiresLogin) && !localStorage.getItem('auth')){
    next({name: 'Login'})
  }
  else if (to.matched.some((record) => record.meta.hasUser) && localStorage.getItem('auth') && localStorage.getItem('isAdmin')) {
      next({ name: "Dashboard" });
	} 
  else if (to.matched.some((record) => record.meta.hasUser) && localStorage.getItem('auth') && localStorage.getItem('isUser')) {
      next({ name: "Status" });
	} 
  else if (to.matched.some((record) => record.meta.isAdmin) && localStorage.getItem('auth') && localStorage.getItem('isUser')) {
      next({ name: "Status" });
	} 
  else if (to.matched.some((record) => record.meta.notAdmin) && !localStorage.getItem('auth') && !localStorage.getItem('isUser')) {
      next({ name: "Index" });
	} else {
		next();
	}
});

export default router
