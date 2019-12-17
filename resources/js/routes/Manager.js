// Layouts
import LayoutBasic from '../views/layouts/LayoutBasic.vue'

/*
 |--------------------------------------------------------------------------
 | Manager Views
 |--------------------------------------------------------------------------|
 */

//Manager Dashboard
import ManagerBasic from '../views/manager/modules/dashboard/Basic.vue'

//Manager Probes
import ManagerProbes from '../views/manager/modules/probes/Index.vue'
import ManagerAddProbes from '../views/manager/modules/probes/Add.vue'
import ManagerEditProbes from '../views/manager/modules/probes/Edit.vue'
import ManagerViewProbes from '../views/manager/modules/probes/View.vue'

//Manager Reports
import ManagerProbesLogs from '../views/manager/modules/probes_logs/Index.vue'

//Manager File Entries
import ManagerFileEntries from '../views/manager/modules/file_entries/Index.vue'

const routes = [
	/*
   |--------------------------------------------------------------------------
   | Manager Backend Routes
   |--------------------------------------------------------------------------|
   */
  {
    path: '/manager',
    component: LayoutBasic, // Change the desired Layout here
    meta: { requiresAuth: true },
    children: [
      // Dashboard
      {
        path: 'dashboard',
        component: ManagerBasic,
        name: 'manager_dashboard'
	  },
	  // Probes - Index
      {
        path: 'probes',
        component: ManagerProbes,
		name: 'manager_probes',
	  },
	  // Probes - Add
      {
        path: 'probes/add',
        component: ManagerAddProbes,
		name: 'manager_add_probes',
	  },
	  // Probes - Edit
      {
        path: 'probes/edit/:id',
        component: ManagerEditProbes,
		name: 'manager_edit_probes',
	  },
	  // Probes - View
      {
        path: 'probes/view/:id',
        component: ManagerViewProbes,
		name: 'manager_view_probes',
	  },
	  // Reports - Probes Logs Index
      {
        path: 'probes_logs',
        component: ManagerProbesLogs,
		name: 'manager_probes_logs',
	  },
	  // File Entries - Index
      {
        path: 'file_entries',
        component: ManagerFileEntries,
		name: 'manager_file_entries',
	  },
    ]
}]

export default routes