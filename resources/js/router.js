import Vue from 'vue'
import VueRouter from 'vue-router'
import AuthService from './services/auth'
//Separate route files for different user levels
import DefaultRoutes from './routes/Default'
import AdminRoutes from './routes/Admin'
import OrganizerRoutes from './routes/Organizer'
import ManagerRoutes from './routes/Manager'
import StaffRoutes from './routes/Staff'

Vue.use(VueRouter)

let allRoutes = []

allRoutes = allRoutes.concat(DefaultRoutes, AdminRoutes, OrganizerRoutes, ManagerRoutes, StaffRoutes)

const routes = allRoutes

const router = new VueRouter({
  routes,
  mode: 'history',
  linkActiveClass: 'active'
})

router.beforeEach((to, from, next) => {
  //  If the next route is requires user to be Logged IN
  if (to.matched.some(m => m.meta.requiresAuth)) {
    return AuthService.check().then(authenticated => {
      if (!authenticated) {
        return next({ path: '/login' })
      }

      return next()
    })
  }

  return next()
})

export default router
