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

//Probes
import Probes from './views/admin/modules/probes/Index.vue'
import AddProbes from './views/admin/modules/probes/Add.vue'
import EditProbes from './views/admin/modules/probes/Edit.vue'
import ViewProbes from './views/admin/modules/probes/View.vue'

//Corrective Actions
import CorrectiveActions from './views/admin/modules/corrective_actions/Index.vue'
import AddCorrectiveActions from './views/admin/modules/corrective_actions/Add.vue'
import EditCorrectiveActions from './views/admin/modules/corrective_actions/Edit.vue'
import ViewCorrectiveActions from './views/admin/modules/corrective_actions/View.vue'

//Cook Chill Checks
import CookChillChecks from './views/admin/modules/cook_chill_checks/Index.vue'
import AddCookChillChecks from './views/admin/modules/cook_chill_checks/Add.vue'
import EditCookChillChecks from './views/admin/modules/cook_chill_checks/Edit.vue'
import ViewCookChillChecks from './views/admin/modules/cook_chill_checks/View.vue'

//Suppliers
import Suppliers from './views/admin/modules/suppliers/Index.vue'
import AddSuppliers from './views/admin/modules/suppliers/Add.vue'
import EditSuppliers from './views/admin/modules/suppliers/Edit.vue'

//Type of Foods
import TypeOfFoods from './views/admin/modules/type_of_foods/Index.vue'
import AddTypeOfFoods from './views/admin/modules/type_of_foods/Add.vue'
import EditTypeOfFoods from './views/admin/modules/type_of_foods/Edit.vue'

//Incoming Deliveries
import IncomingDeliveries from './views/admin/modules/incoming_deliveries/Index.vue'
import AddIncomingDeliveries from './views/admin/modules/incoming_deliveries/Add.vue'
import EditIncomingDeliveries from './views/admin/modules/incoming_deliveries/Edit.vue'
import ViewIncomingDeliveries from './views/admin/modules/incoming_deliveries/View.vue'

//Incoming Deliveries Items
import IncomingDeliveriesItems from './views/admin/modules/incoming_deliveries_items/Index.vue'
import AddIncomingDeliveriesItems from './views/admin/modules/incoming_deliveries_items/Add.vue'
import EditIncomingDeliveriesItems from './views/admin/modules/incoming_deliveries_items/Edit.vue'

//Incoming Deliveries Categories
import IncomingDeliveriesCategories from './views/admin/modules/incoming_deliveries_categories/Index.vue'
import AddIncomingDeliveriesCategories from './views/admin/modules/incoming_deliveries_categories/Add.vue'
import EditIncomingDeliveriesCategories from './views/admin/modules/incoming_deliveries_categories/Edit.vue'

//Incoming Deliveries Type Of Products
import IncomingDeliveriesTypeOfProducts from './views/admin/modules/incoming_deliveries_type_of_products/Index.vue'
import AddIncomingDeliveriesTypeOfProducts from './views/admin/modules/incoming_deliveries_type_of_products/Add.vue'
import EditIncomingDeliveriesTypeOfProducts from './views/admin/modules/incoming_deliveries_type_of_products/Edit.vue'

//Incoming Deliveries Corrective Actions
import IncomingDeliveriesCorrectiveActions from './views/admin/modules/incoming_deliveries_corrective_actions/Index.vue'
import AddIncomingDeliveriesCorrectiveActions from './views/admin/modules/incoming_deliveries_corrective_actions/Add.vue'
import EditIncomingDeliveriesCorrectiveActions from './views/admin/modules/incoming_deliveries_corrective_actions/Edit.vue'

//Staff Daily Checklists
import StaffDailyChecklists from './views/admin/modules/staff_daily_checklists/Index.vue'
import AddStaffDailyChecklists from './views/admin/modules/staff_daily_checklists/Add.vue'
import ViewStaffDailyChecklists from './views/admin/modules/staff_daily_checklists/View.vue'

//Matrix Checklists
import MatrixChecklists from './views/admin/modules/matrix_checklists/Index.vue'
import AddMatrixChecklists from './views/admin/modules/matrix_checklists/Add.vue'
import ViewMatrixChecklists from './views/admin/modules/matrix_checklists/View.vue'

//Organizations
import Organizations from './views/admin/modules/organizations/Index.vue'
import AddOrganizations from './views/admin/modules/organizations/Add.vue'
import EditOrganizations from './views/admin/modules/organizations/Edit.vue'
import ViewOrganizations from './views/admin/modules/organizations/View.vue'

//Locations
import Locations from './views/admin/modules/locations/Index.vue'
import AddLocations from './views/admin/modules/locations/Add.vue'
import EditLocations from './views/admin/modules/locations/Edit.vue'
import ViewLocations from './views/admin/modules/locations/View.vue'

//Users
import Users from './views/admin/modules/users/Index.vue'
import AddUsers from './views/admin/modules/users/Add.vue'
import EditUsers from './views/admin/modules/users/Edit.vue'
import ViewUsers from './views/admin/modules/users/View.vue'

//Set Checklists 
import Checklists from './views/admin/modules/checklists/Index.vue'

//Checklist Areas
import AddChecklistAreas from './views/admin/modules/checklist_areas/Add.vue'
import EditChecklistAreas from './views/admin/modules/checklist_areas/Edit.vue'

//Checklist Times
import AddChecklistTimes from './views/admin/modules/checklist_times/Add.vue'
import EditChecklistTimes from './views/admin/modules/checklist_times/Edit.vue'

//Checklist Categories
import AddChecklistCategories from './views/admin/modules/checklist_categories/Add.vue'
import EditChecklistCategories from './views/admin/modules/checklist_categories/Edit.vue'

//Checklist Items
import AddChecklistItems from './views/admin/modules/checklist_items/Add.vue'
import EditChecklistItems from './views/admin/modules/checklist_items/Edit.vue'

//Manage Checklists
import ManageChecklists from './views/admin/modules/manage_checklists/Index.vue'
import AddManageChecklists from './views/admin/modules/manage_checklists/Add.vue'
import EditManageChecklists from './views/admin/modules/manage_checklists/Edit.vue'
import ViewManageChecklists from './views/admin/modules/manage_checklists/View.vue'

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
	  // Probes - Index
      {
        path: 'probes',
        component: Probes,
		name: 'probes',
	  },
	  // Probes - Add
      {
        path: 'probes/add',
        component: AddProbes,
		name: 'add_probes',
	  },
	  // Probes - Edit
      {
        path: 'probes/edit/:id',
        component: EditProbes,
		name: 'edit_probes',
	  },
	  // Probes - View
      {
        path: 'probes/view/:id',
        component: ViewProbes,
		name: 'view_probes',
	  },
	  // Corrective Actions - Index
      {
        path: 'corrective_actions',
        component: CorrectiveActions,
		name: 'corrective_actions',
	  },
	  // Corrective Actions - Add
      {
        path: 'corrective_actions/add',
        component: AddCorrectiveActions,
		name: 'add_corrective_actions',
	  },
	  // Corrective Actions - Edit
      {
        path: 'corrective_actions/edit/:id',
        component: EditCorrectiveActions,
		name: 'edit_corrective_actions',
	  },
	  // Corrective Actions - View
      {
        path: 'corrective_actions/view/:id',
        component: ViewCorrectiveActions,
		name: 'view_corrective_actions',
	  },
	  // Cook Chill Checks - Index
      {
        path: 'cook_chill_checks',
        component: CookChillChecks,
		name: 'cook_chill_checks',
	  },
	  // Cook Chill Checks - Add
      {
        path: 'cook_chill_checks/add',
        component: AddCookChillChecks,
		name: 'add_cook_chill_checks',
	  },
	  // Cook Chill Checks - Edit
      {
        path: 'cook_chill_checks/edit/:id',
        component: EditCookChillChecks,
		name: 'edit_cook_chill_checks',
	  },
	  // Cook Chill Checks - View
      {
        path: 'cook_chill_checks/view/:id',
        component: ViewCookChillChecks,
		name: 'view_cook_chill_checks',
	  },
	  // Suppliers - Index
      {
        path: 'suppliers',
        component: Suppliers,
		name: 'suppliers',
	  },
	  // Suppliers - Add
      {
        path: 'suppliers/add',
        component: AddSuppliers,
		name: 'add_suppliers',
	  },
	  // Suppliers - Edit
      {
        path: 'suppliers/edit/:id',
        component: EditSuppliers,
		name: 'edit_suppliers',
	  },
	  // Type of Foods - Index
      {
        path: 'type_of_foods',
        component: TypeOfFoods,
		name: 'type_of_foods',
	  },
	  // Type of Foods - Add
      {
        path: 'type_of_foods/add',
        component: AddTypeOfFoods,
		name: 'add_type_of_foods',
	  },
	  // Type of Foods - Edit
      {
        path: 'type_of_foods/edit/:id',
        component: EditTypeOfFoods,
		name: 'edit_type_of_foods',
	  },
	  // Incoming Deliveries - Index
      {
        path: 'incoming_deliveries',
        component: IncomingDeliveries,
		name: 'incoming_deliveries',
	  },
	  // Incoming Deliveries - Add
      {
        path: 'incoming_deliveries/add',
        component: AddIncomingDeliveries,
		name: 'add_incoming_deliveries',
	  },
	  // Incoming Deliveries - Edit
      {
        path: 'incoming_deliveries/edit/:id',
        component: EditIncomingDeliveries,
		name: 'edit_incoming_deliveries',
	  },
	  // Incoming Deliveries - View
      {
        path: 'incoming_deliveries/view/:id',
        component: ViewIncomingDeliveries,
		name: 'view_incoming_deliveries',
	  },
	  // Incoming Deliveries Items - Index
      {
        path: 'incoming_deliveries_items',
        component: IncomingDeliveriesItems,
		name: 'incoming_deliveries_items',
	  },
	  // Incoming Deliveries Items - Add
      {
        path: 'incoming_deliveries_items/add',
        component: AddIncomingDeliveriesItems,
		name: 'add_incoming_deliveries_items',
	  },
	  // Incoming Deliveries Items - Edit
      {
        path: 'incoming_deliveries_items/edit/:id',
        component: EditIncomingDeliveriesItems,
		name: 'edit_incoming_deliveries_items',
	  },
	  // Incoming Deliveries Categories - Index
      {
        path: 'incoming_deliveries_categories',
        component: IncomingDeliveriesCategories,
		name: 'incoming_deliveries_categories',
	  },
	  // Incoming Deliveries Categories - Add
      {
        path: 'incoming_deliveries_categories/add',
        component: AddIncomingDeliveriesCategories,
		name: 'add_incoming_deliveries_categories',
	  },
	  // Incoming Deliveries Categories - Edit
      {
        path: 'incoming_deliveries_categories/edit/:id',
        component: EditIncomingDeliveriesCategories,
		name: 'edit_incoming_deliveries_categories',
	  },
	  // Incoming Deliveries Type Of Products - Index
      {
        path: 'incoming_deliveries_type_of_products',
        component: IncomingDeliveriesTypeOfProducts,
		name: 'incoming_deliveries_type_of_products',
	  },
	  // Incoming Deliveries Type Of Products - Add
      {
        path: 'incoming_deliveries_type_of_products/add',
        component: AddIncomingDeliveriesTypeOfProducts,
		name: 'add_incoming_deliveries_type_of_products',
	  },
	  // Incoming Deliveries Type Of Products - Edit
      {
        path: 'incoming_deliveries_type_of_products/edit/:id',
        component: EditIncomingDeliveriesTypeOfProducts,
		name: 'edit_incoming_deliveries_type_of_products',
	  },
	  // Incoming Deliveries Corrective Actions - Index
      {
        path: 'incoming_deliveries_corrective_actions',
        component: IncomingDeliveriesCorrectiveActions,
		name: 'incoming_deliveries_corrective_actions',
	  },
	  // Incoming Deliveries Corrective Actions - Add
      {
        path: 'incoming_deliveries_corrective_actions/add',
        component: AddIncomingDeliveriesCorrectiveActions,
		name: 'add_incoming_deliveries_corrective_actions',
	  },
	  // Incoming Deliveries Corrective Actions - Edit
      {
        path: 'incoming_deliveries_corrective_actions/edit/:id',
        component: EditIncomingDeliveriesCorrectiveActions,
		name: 'edit_incoming_deliveries_corrective_actions',
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
	  // Locations - Index
      {
        path: 'locations',
        component: Locations,
		name: 'locations',
	  },
	  // Locations - Add
      {
        path: 'locations/add',
        component: AddLocations,
		name: 'add_locations',
	  },
	  // Locations - Edit
      {
        path: 'locations/edit/:id',
        component: EditLocations,
		name: 'edit_locations',
	  },
	  // Locations - View
      {
        path: 'locations/view/:id',
        component: ViewLocations,
		name: 'view_locations',
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
	  // Checklists - Index
      {
        path: 'checklists',
        component: Checklists,
		name: 'checklists',
	  },
	  // Checklist Areas - Add
      {
        path: 'checklist_areas/add',
        component: AddChecklistAreas,
		name: 'add_checklist_areas',
	  },
	  // Checklist Areas - Edit
      {
        path: 'checklist_areas/edit/:id',
        component: EditChecklistAreas,
		name: 'edit_checklist_areas',
	  },
	  // Checklist Times - Add
      {
        path: 'checklist_times/add',
        component: AddChecklistTimes,
		name: 'add_checklist_times',
	  },
	  // Checklist Times - Edit
      {
        path: 'checklist_times/edit/:id',
        component: EditChecklistTimes,
		name: 'edit_checklist_times',
	  },
	  // Checklist Categories - Add
      {
        path: 'checklist_categories/add',
        component: AddChecklistCategories,
		name: 'add_checklist_categories',
	  },
	  // Checklist Categories - Edit
      {
        path: 'checklist_categories/edit/:id',
        component: EditChecklistCategories,
		name: 'edit_checklist_categories',
	  },
	  // Checklist Items - Add
      {
        path: 'checklist_items/add',
        component: AddChecklistItems,
		name: 'add_checklist_items',
	  },
	  // Checklist Items - Edit
      {
        path: 'checklist_items/edit/:id',
        component: EditChecklistItems,
		name: 'edit_checklist_items',
	  },
	  // Manage Checklists - Index
      {
        path: 'manage_checklists',
        component: ManageChecklists,
		name: 'manage_checklists',
	  },
	  // Manage Checklists - Add
      {
        path: 'manage_checklists/add',
        component: AddManageChecklists,
		name: 'add_manage_checklists',
	  },
	  // Manage Checklists - Edit
      {
        path: 'manage_checklists/edit/:id',
        component: EditManageChecklists,
		name: 'edit_manage_checklists',
	  },
	  // Manage Checklists - View
      {
        path: 'manage_checklists/view/:id',
        component: ViewManageChecklists,
		name: 'view_manage_checklists',
	  },
	  // Staff Daily Checklists - Index
      {
        path: 'staff_daily_checklists',
        component: StaffDailyChecklists,
		name: 'staff_daily_checklists',
	  },
	  // Staff Daily Checklists - Add
      {
        path: 'staff_daily_checklists/add',
        component: AddStaffDailyChecklists,
		name: 'add_staff_daily_checklists',
	  },
	  // Staff Daily Checklists - View
      {
        path: 'staff_daily_checklists/view/:id',
        component: ViewStaffDailyChecklists,
		name: 'view_staff_daily_checklists',
	  },
	  // Matrix Checklists - Index
      {
        path: 'matrix_checklists',
        component: MatrixChecklists,
		name: 'matrix_checklists',
	  },
	  // Matrix Checklists - Add
      {
        path: 'matrix_checklists/add',
        component: AddMatrixChecklists,
		name: 'add_matrix_checklists',
	  },
	  // Matrix Checklists - View
      {
        path: 'matrix_checklists/view/:id',
        component: ViewMatrixChecklists,
		name: 'view_matrix_checklists',
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
