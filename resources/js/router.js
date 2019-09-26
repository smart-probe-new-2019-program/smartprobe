import Vue from 'vue'
import VueRouter from 'vue-router'
import AuthService from './services/auth'

/*
 |--------------------------------------------------------------------------
 | Admin Views
 |--------------------------------------------------------------------------|
 */

// Dashboard
import Basic from './views/admin/dashboard/Basic.vue'

//Organizations
import Organizations from './views/admin/modules/organizations/Index.vue'
import AddOrganizations from './views/admin/modules/organizations/Add.vue'
import EditOrganizations from './views/admin/modules/organizations/Edit.vue'
import ViewOrganizations from './views/admin/modules/organizations/View.vue'

//Users
import Users from './views/admin/modules/users/Index.vue'
import AddUsers from './views/admin/modules/users/Add.vue'
import EditUsers from './views/admin/modules/users/Edit.vue'
import ViewUsers from './views/admin/modules/users/View.vue'

// Layouts
import LayoutBasic from './views/layouts/LayoutBasic.vue'
import LayoutLogin from './views/layouts/LayoutLogin.vue'

/*
 |--------------------------------------------------------------------------
 | Other
 |--------------------------------------------------------------------------|
 */

// Auth
import Login from './views/auth/Login.vue'
import NotFoundPage from './views/errors/404.vue'

/*
 |--------------------------------------------------------------------------
 | Frontend Views
 |--------------------------------------------------------------------------|
 */

import Home from './views/front/Home.vue'

Vue.use(VueRouter)

const routes = [

  /*
   |--------------------------------------------------------------------------
   | Frontend Routes
   |--------------------------------------------------------------------------|
   */

  {
    path: '/',
    component: LayoutLogin,
    children: [
      {
        path: '/',
        component: Login,
        name: 'loginWithoutParams'
      }
    ]
  },

  /*
   |--------------------------------------------------------------------------
   | Admin Backend Routes
   |--------------------------------------------------------------------------|
   */
  {
    path: '/admin',
    component: LayoutBasic, // Change the desired Layout here
    meta: { requiresAuth: true },
    children: [
      // Dashboard
      {
        path: 'dashboard',
        component: Basic,
        name: 'dashboard'
	  },
	  // Organizations - Index
      {
        path: 'organizations',
        component: Organizations,
		name: 'organizations',
	  },
	  // Organizations - Add
      {
        path: 'organizations/add',
        component: AddOrganizations,
		name: 'add_organizations',
	  },
	  // Organizations - Edit
      {
        path: 'organizations/edit/:id',
        component: EditOrganizations,
		name: 'edit_organizations',
	  },
	  // Organizations - View
      {
        path: 'organizations/view/:id',
        component: ViewOrganizations,
		name: 'view_organizations',
	  },
	  // Users - Index
      {
        path: 'users',
        component: Users,
		name: 'users',
	  },
	  // Users - Add
      {
        path: 'users/add',
        component: AddUsers,
		name: 'add_users',
	  },
	  // Users - Edit
      {
        path: 'users/edit/:id',
        component: EditUsers,
		name: 'edit_users',
	  },
	  // Users - View
      {
        path: 'users/view/:id',
        component: ViewUsers,
		name: 'view_users',
	  },
    ]
  },

  /*
   |--------------------------------------------------------------------------
   | Auth & Registration Routes
   |--------------------------------------------------------------------------|
   */

  {
    path: '/',
    component: LayoutLogin,
    children: [
      {
        path: 'login',
        component: Login,
        name: 'login'
      },
    //   {
    //     path: 'register',
    //     component: Register,
    //     name: 'register'
    //   }
    ]
  },

  //  DEFAULT ROUTE
  { path: '*', component: NotFoundPage }
]

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
