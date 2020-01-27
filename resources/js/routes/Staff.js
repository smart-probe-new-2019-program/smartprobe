// Layouts
import LayoutBasic from "../views/layouts/LayoutBasic.vue";

/*
 |--------------------------------------------------------------------------
 | Staff Views
 |--------------------------------------------------------------------------|
 */

//Staff Dashboard
import StaffBasic from "../views/staff/modules/dashboard/Index.vue";

//Staff Corrective Actions
import StaffCorrectiveActions from "../views/staff/modules/corrective_actions/Index.vue";
import StaffAddCorrectiveActions from "../views/staff/modules/corrective_actions/Add.vue";
import StaffEditCorrectiveActions from "../views/staff/modules/corrective_actions/Edit.vue";
import StaffViewCorrectiveActions from "../views/staff/modules/corrective_actions/View.vue";

//Staff Cook Chill Checks
import StaffCookChillChecks from "../views/staff/modules/cook_chill_checks/Index.vue";
import StaffAddCookChillChecks from "../views/staff/modules/cook_chill_checks/Add.vue";
import StaffEditCookChillChecks from "../views/staff/modules/cook_chill_checks/Edit.vue";
import StaffViewCookChillChecks from "../views/staff/modules/cook_chill_checks/View.vue";

//Staff Incoming Deliveries
import StaffIncomingDeliveries from "../views/staff/modules/incoming_deliveries/Index.vue";
import StaffAddIncomingDeliveries from "../views/staff/modules/incoming_deliveries/Add.vue";
import StaffEditIncomingDeliveries from "../views/staff/modules/incoming_deliveries/Edit.vue";
import StaffViewIncomingDeliveries from "../views/staff/modules/incoming_deliveries/View.vue";

//Staff Staff Daily Checklists
import StaffStaffDailyChecklists from "../views/staff/modules/staff_daily_checklists/Index.vue";
import StaffAddStaffDailyChecklists from "../views/staff/modules/staff_daily_checklists/Add.vue";
import StaffViewStaffDailyChecklists from "../views/staff/modules/staff_daily_checklists/View.vue";

//Staff Matrix Checklists
import StaffMatrixChecklists from "../views/staff/modules/matrix_checklists/Index.vue";
import StaffAddMatrixChecklists from "../views/staff/modules/matrix_checklists/Add.vue";
import StaffViewMatrixChecklists from "../views/staff/modules/matrix_checklists/View.vue";

//Staff File Entries
import StaffFileEntries from "../views/staff/modules/file_entries/Index.vue";

const routes = [
  /*
   |--------------------------------------------------------------------------
   | Staff Backend Routes
   |--------------------------------------------------------------------------|
   */
  {
    path: "/staff",
    component: LayoutBasic, // Change the desired Layout here
    meta: { requiresAuth: true },
    children: [
      // Dashboard
      {
        path: "dashboard",
        component: StaffBasic,
        name: "staff_dashboard"
      },
      // Corrective Actions - Index
      {
        path: "corrective_actions",
        component: StaffCorrectiveActions,
        name: "staff_corrective_actions"
      },
      // Corrective Actions - Add
      {
        path: "corrective_actions/add",
        component: StaffAddCorrectiveActions,
        name: "staff_add_corrective_actions"
      },
      // Corrective Actions - Edit
      {
        path: "corrective_actions/edit/:id",
        component: StaffEditCorrectiveActions,
        name: "staff_edit_corrective_actions"
      },
      // Corrective Actions - View
      {
        path: "corrective_actions/view/:id",
        component: StaffViewCorrectiveActions,
        name: "staff_view_corrective_actions"
      },
      // Cook Chill Checks - Index
      {
        path: "cook_chill_checks",
        component: StaffCookChillChecks,
        name: "staff_cook_chill_checks"
      },
      // Cook Chill Checks - Add
      {
        path: "cook_chill_checks/add",
        component: StaffAddCookChillChecks,
        name: "staff_add_cook_chill_checks"
      },
      // Cook Chill Checks - Edit
      {
        path: "cook_chill_checks/edit/:id",
        component: StaffEditCookChillChecks,
        name: "staff_edit_cook_chill_checks"
      },
      // Cook Chill Checks - View
      {
        path: "cook_chill_checks/view/:id",
        component: StaffViewCookChillChecks,
        name: "staff_view_cook_chill_checks"
      },
      // Incoming Deliveries - Index
      {
        path: "incoming_deliveries",
        component: StaffIncomingDeliveries,
        name: "staff_incoming_deliveries"
      },
      // Incoming Deliveries - Add
      {
        path: "incoming_deliveries/add",
        component: StaffAddIncomingDeliveries,
        name: "staff_add_incoming_deliveries"
      },
      // Incoming Deliveries - Edit
      {
        path: "incoming_deliveries/edit/:id",
        component: StaffEditIncomingDeliveries,
        name: "staff_edit_incoming_deliveries"
      },
      // Incoming Deliveries - View
      {
        path: "incoming_deliveries/view/:id",
        component: StaffViewIncomingDeliveries,
        name: "staff_view_incoming_deliveries"
      },
      // File Entries - Index
      {
        path: "file_entries",
        component: StaffFileEntries,
        name: "staff_file_entries"
      },
      // Staff Daily Checklists - Index
      {
        path: "staff_daily_checklists",
        component: StaffStaffDailyChecklists,
        name: "staff_staff_daily_checklists"
      },
      // Staff Daily Checklists - Add
      {
        path: "staff_daily_checklists/add",
        component: StaffAddStaffDailyChecklists,
        name: "staff_add_staff_daily_checklists"
      },
      // Staff Daily Checklists - View
      {
        path: "staff_daily_checklists/view/:id",
        component: StaffViewStaffDailyChecklists,
        name: "staff_view_staff_daily_checklists"
      },
      // Matrix Checklists - Index
      {
        path: "matrix_checklists",
        component: StaffMatrixChecklists,
        name: "staff_matrix_checklists"
      },
      // Matrix Checklists - Add
      {
        path: "matrix_checklists/add",
        component: StaffAddMatrixChecklists,
        name: "staff_add_matrix_checklists"
      },
      // Matrix Checklists - View
      {
        path: "matrix_checklists/view/:id",
        component: StaffViewMatrixChecklists,
        name: "staff_view_matrix_checklists"
      }
    ]
  }
];

export default routes;
