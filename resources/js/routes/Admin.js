// Layouts
import LayoutBasic from "../views/layouts/LayoutBasic.vue";

/*
 |--------------------------------------------------------------------------
 | Admin Views
 |--------------------------------------------------------------------------|
 */

//Admin Dashboard
import AdminBasic from "../views/admin/modules/dashboard/Index.vue";

//Admin Probes
import AdminProbes from "../views/admin/modules/probes/Index.vue";
import AdminAddProbes from "../views/admin/modules/probes/Add.vue";
import AdminEditProbes from "../views/admin/modules/probes/Edit.vue";
import AdminViewProbes from "../views/admin/modules/probes/View.vue";

//Admin Corrective Actions
import AdminCorrectiveActions from "../views/admin/modules/corrective_actions/Index.vue";
import AdminAddCorrectiveActions from "../views/admin/modules/corrective_actions/Add.vue";
import AdminEditCorrectiveActions from "../views/admin/modules/corrective_actions/Edit.vue";
import AdminViewCorrectiveActions from "../views/admin/modules/corrective_actions/View.vue";

//Admin Reports
import AdminProbesLogs from "../views/admin/modules/probes_logs/Index.vue";
import AdminTempCheckLogs from "../views/admin/modules/temp_check_logs/Index.vue";

//Admin Cook Chill Checks
import AdminCookChillChecks from "../views/admin/modules/cook_chill_checks/Index.vue";
import AdminAddCookChillChecks from "../views/admin/modules/cook_chill_checks/Add.vue";
import AdminEditCookChillChecks from "../views/admin/modules/cook_chill_checks/Edit.vue";
import AdminViewCookChillChecks from "../views/admin/modules/cook_chill_checks/View.vue";

//Admin Suppliers
import AdminSuppliers from "../views/admin/modules/suppliers/Index.vue";
import AdminAddSuppliers from "../views/admin/modules/suppliers/Add.vue";
import AdminEditSuppliers from "../views/admin/modules/suppliers/Edit.vue";

//Admin Type of Foods
import AdminTypeOfFoods from "../views/admin/modules/type_of_foods/Index.vue";
import AdminAddTypeOfFoods from "../views/admin/modules/type_of_foods/Add.vue";
import AdminEditTypeOfFoods from "../views/admin/modules/type_of_foods/Edit.vue";

//Admin Incoming Deliveries
import AdminIncomingDeliveries from "../views/admin/modules/incoming_deliveries/Index.vue";
import AdminAddIncomingDeliveries from "../views/admin/modules/incoming_deliveries/Add.vue";
import AdminEditIncomingDeliveries from "../views/admin/modules/incoming_deliveries/Edit.vue";
import AdminViewIncomingDeliveries from "../views/admin/modules/incoming_deliveries/View.vue";

//Admin Incoming Deliveries Items
import AdminIncomingDeliveriesItems from "../views/admin/modules/incoming_deliveries_items/Index.vue";
import AdminAddIncomingDeliveriesItems from "../views/admin/modules/incoming_deliveries_items/Add.vue";
import AdminEditIncomingDeliveriesItems from "../views/admin/modules/incoming_deliveries_items/Edit.vue";

//Admin Incoming Deliveries Categories
import AdminIncomingDeliveriesCategories from "../views/admin/modules/incoming_deliveries_categories/Index.vue";
import AdminAddIncomingDeliveriesCategories from "../views/admin/modules/incoming_deliveries_categories/Add.vue";
import AdminEditIncomingDeliveriesCategories from "../views/admin/modules/incoming_deliveries_categories/Edit.vue";

//Admin Incoming Deliveries Type Of Products
import AdminIncomingDeliveriesTypeOfProducts from "../views/admin/modules/incoming_deliveries_type_of_products/Index.vue";
import AdminAddIncomingDeliveriesTypeOfProducts from "../views/admin/modules/incoming_deliveries_type_of_products/Add.vue";
import AdminEditIncomingDeliveriesTypeOfProducts from "../views/admin/modules/incoming_deliveries_type_of_products/Edit.vue";

//Admin Incoming Deliveries Corrective Actions
import AdminIncomingDeliveriesCorrectiveActions from "../views/admin/modules/incoming_deliveries_corrective_actions/Index.vue";
import AdminAddIncomingDeliveriesCorrectiveActions from "../views/admin/modules/incoming_deliveries_corrective_actions/Add.vue";
import AdminEditIncomingDeliveriesCorrectiveActions from "../views/admin/modules/incoming_deliveries_corrective_actions/Edit.vue";

//Admin Staff Daily Checklists
import AdminStaffDailyChecklists from "../views/admin/modules/staff_daily_checklists/Index.vue";
import AdminAddStaffDailyChecklists from "../views/admin/modules/staff_daily_checklists/Add.vue";
import AdminViewStaffDailyChecklists from "../views/admin/modules/staff_daily_checklists/View.vue";

//Admin Matrix Checklists
import AdminMatrixChecklists from "../views/admin/modules/matrix_checklists/Index.vue";
import AdminAddMatrixChecklists from "../views/admin/modules/matrix_checklists/Add.vue";
import AdminViewMatrixChecklists from "../views/admin/modules/matrix_checklists/View.vue";

//Admin Organizations
import AdminOrganizations from "../views/admin/modules/organizations/Index.vue";
import AdminAddOrganizations from "../views/admin/modules/organizations/Add.vue";
import AdminEditOrganizations from "../views/admin/modules/organizations/Edit.vue";
import AdminViewOrganizations from "../views/admin/modules/organizations/View.vue";

//Admin Locations
import AdminLocations from "../views/admin/modules/locations/Index.vue";
import AdminAddLocations from "../views/admin/modules/locations/Add.vue";
import AdminEditLocations from "../views/admin/modules/locations/Edit.vue";
import AdminViewLocations from "../views/admin/modules/locations/View.vue";

//Admin Contacts
import AdminContacts from "../views/admin/modules/contacts/Index.vue";
import AdminAddContacts from "../views/admin/modules/contacts/Add.vue";
import AdminEditContacts from "../views/admin/modules/contacts/Edit.vue";

//Admin File Entries
import AdminFileEntries from "../views/admin/modules/file_entries/Index.vue";
import AdminAddFileEntries from "../views/admin/modules/file_entries/Add.vue";

//Admin Users
import AdminUsers from "../views/admin/modules/users/Index.vue";
import AdminAddUsers from "../views/admin/modules/users/Add.vue";
import AdminEditUsers from "../views/admin/modules/users/Edit.vue";
import AdminViewUsers from "../views/admin/modules/users/View.vue";

//Admin Set Checklists
import AdminChecklists from "../views/admin/modules/checklists/Index.vue";

//Admin Checklist Areas
import AdminAddChecklistAreas from "../views/admin/modules/checklist_areas/Add.vue";
import AdminEditChecklistAreas from "../views/admin/modules/checklist_areas/Edit.vue";

//Admin Checklist Times
import AdminAddChecklistTimes from "../views/admin/modules/checklist_times/Add.vue";
import AdminEditChecklistTimes from "../views/admin/modules/checklist_times/Edit.vue";

//Admin Checklist Categories
import AdminAddChecklistCategories from "../views/admin/modules/checklist_categories/Add.vue";
import AdminEditChecklistCategories from "../views/admin/modules/checklist_categories/Edit.vue";

//Admin Checklist Items
import AdminAddChecklistItems from "../views/admin/modules/checklist_items/Add.vue";
import AdminEditChecklistItems from "../views/admin/modules/checklist_items/Edit.vue";

//Admin Manage Checklists
import AdminManageChecklists from "../views/admin/modules/manage_checklists/Index.vue";
import AdminAddManageChecklists from "../views/admin/modules/manage_checklists/Add.vue";
import AdminEditManageChecklists from "../views/admin/modules/manage_checklists/Edit.vue";
import AdminViewManageChecklists from "../views/admin/modules/manage_checklists/View.vue";

const routes = [
  /*
   |--------------------------------------------------------------------------
   | Admin Backend Routes
   |--------------------------------------------------------------------------|
   */
  {
    path: "/admin",
    component: LayoutBasic, // Change the desired Layout here
    meta: { requiresAuth: true },
    children: [
      // Dashboard
      {
        path: "dashboard",
        component: AdminBasic,
        name: "admin_dashboard"
      },
      // Probes - Index
      {
        path: "probes",
        component: AdminProbes,
        name: "admin_probes"
      },
      // Probes - Add
      {
        path: "probes/add",
        component: AdminAddProbes,
        name: "admin_add_probes"
      },
      // Probes - Edit
      {
        path: "probes/edit/:id",
        component: AdminEditProbes,
        name: "admin_edit_probes"
      },
      // Probes - View
      {
        path: "probes/view/:id",
        component: AdminViewProbes,
        name: "admin_view_probes"
      },
      // Corrective Actions - Index
      {
        path: "corrective_actions",
        component: AdminCorrectiveActions,
        name: "admin_corrective_actions"
      },
      // Corrective Actions - Add
      {
        path: "corrective_actions/add",
        component: AdminAddCorrectiveActions,
        name: "admin_add_corrective_actions"
      },
      // Corrective Actions - Edit
      {
        path: "corrective_actions/edit/:id",
        component: AdminEditCorrectiveActions,
        name: "admin_edit_corrective_actions"
      },
      // Corrective Actions - View
      {
        path: "corrective_actions/view/:id",
        component: AdminViewCorrectiveActions,
        name: "admin_view_corrective_actions"
      },
      // Reports - Probes Logs Index
      {
        path: "probes_logs",
        component: AdminProbesLogs,
        name: "admin_probes_logs"
      },
      // Reports - Temp Check Logs Index
      {
        path: "temp_check_logs",
        component: AdminTempCheckLogs,
        name: "admin_temp_check_logs"
      },
      // Cook Chill Checks - Index
      {
        path: "cook_chill_checks",
        component: AdminCookChillChecks,
        name: "admin_cook_chill_checks"
      },
      // Cook Chill Checks - Add
      {
        path: "cook_chill_checks/add",
        component: AdminAddCookChillChecks,
        name: "admin_add_cook_chill_checks"
      },
      // Cook Chill Checks - Edit
      {
        path: "cook_chill_checks/edit/:id",
        component: AdminEditCookChillChecks,
        name: "admin_edit_cook_chill_checks"
      },
      // Cook Chill Checks - View
      {
        path: "cook_chill_checks/view/:id",
        component: AdminViewCookChillChecks,
        name: "admin_view_cook_chill_checks"
      },
      // Suppliers - Index
      {
        path: "suppliers",
        component: AdminSuppliers,
        name: "admin_suppliers"
      },
      // Suppliers - Add
      {
        path: "suppliers/add",
        component: AdminAddSuppliers,
        name: "admin_add_suppliers"
      },
      // Suppliers - Edit
      {
        path: "suppliers/edit/:id",
        component: AdminEditSuppliers,
        name: "admin_edit_suppliers"
      },
      // Type of Foods - Index
      {
        path: "type_of_foods",
        component: AdminTypeOfFoods,
        name: "admin_type_of_foods"
      },
      // Type of Foods - Add
      {
        path: "type_of_foods/add",
        component: AdminAddTypeOfFoods,
        name: "admin_add_type_of_foods"
      },
      // Type of Foods - Edit
      {
        path: "type_of_foods/edit/:id",
        component: AdminEditTypeOfFoods,
        name: "admin_edit_type_of_foods"
      },
      // Incoming Deliveries - Index
      {
        path: "incoming_deliveries",
        component: AdminIncomingDeliveries,
        name: "admin_incoming_deliveries"
      },
      // Incoming Deliveries - Add
      {
        path: "incoming_deliveries/add",
        component: AdminAddIncomingDeliveries,
        name: "admin_add_incoming_deliveries"
      },
      // Incoming Deliveries - Edit
      {
        path: "incoming_deliveries/edit/:id",
        component: AdminEditIncomingDeliveries,
        name: "admin_edit_incoming_deliveries"
      },
      // Incoming Deliveries - View
      {
        path: "incoming_deliveries/view/:id",
        component: AdminViewIncomingDeliveries,
        name: "admin_view_incoming_deliveries"
      },
      // Incoming Deliveries Items - Index
      {
        path: "incoming_deliveries_items",
        component: AdminIncomingDeliveriesItems,
        name: "admin_incoming_deliveries_items"
      },
      // Incoming Deliveries Items - Add
      {
        path: "incoming_deliveries_items/add",
        component: AdminAddIncomingDeliveriesItems,
        name: "admin_add_incoming_deliveries_items"
      },
      // Incoming Deliveries Items - Edit
      {
        path: "incoming_deliveries_items/edit/:id",
        component: AdminEditIncomingDeliveriesItems,
        name: "admin_edit_incoming_deliveries_items"
      },
      // Incoming Deliveries Categories - Index
      {
        path: "incoming_deliveries_categories",
        component: AdminIncomingDeliveriesCategories,
        name: "admin_incoming_deliveries_categories"
      },
      // Incoming Deliveries Categories - Add
      {
        path: "incoming_deliveries_categories/add",
        component: AdminAddIncomingDeliveriesCategories,
        name: "admin_add_incoming_deliveries_categories"
      },
      // Incoming Deliveries Categories - Edit
      {
        path: "incoming_deliveries_categories/edit/:id",
        component: AdminEditIncomingDeliveriesCategories,
        name: "admin_edit_incoming_deliveries_categories"
      },
      // Incoming Deliveries Type Of Products - Index
      {
        path: "incoming_deliveries_type_of_products",
        component: AdminIncomingDeliveriesTypeOfProducts,
        name: "admin_incoming_deliveries_type_of_products"
      },
      // Incoming Deliveries Type Of Products - Add
      {
        path: "incoming_deliveries_type_of_products/add",
        component: AdminAddIncomingDeliveriesTypeOfProducts,
        name: "admin_add_incoming_deliveries_type_of_products"
      },
      // Incoming Deliveries Type Of Products - Edit
      {
        path: "incoming_deliveries_type_of_products/edit/:id",
        component: AdminEditIncomingDeliveriesTypeOfProducts,
        name: "admin_edit_incoming_deliveries_type_of_products"
      },
      // Incoming Deliveries Corrective Actions - Index
      {
        path: "incoming_deliveries_corrective_actions",
        component: AdminIncomingDeliveriesCorrectiveActions,
        name: "admin_incoming_deliveries_corrective_actions"
      },
      // Incoming Deliveries Corrective Actions - Add
      {
        path: "incoming_deliveries_corrective_actions/add",
        component: AdminAddIncomingDeliveriesCorrectiveActions,
        name: "admin_add_incoming_deliveries_corrective_actions"
      },
      // Incoming Deliveries Corrective Actions - Edit
      {
        path: "incoming_deliveries_corrective_actions/edit/:id",
        component: AdminEditIncomingDeliveriesCorrectiveActions,
        name: "admin_edit_incoming_deliveries_corrective_actions"
      },
      // Organizations - Index
      {
        path: "organizations",
        component: AdminOrganizations,
        name: "admin_organizations"
      },
      // Organizations - Add
      {
        path: "organizations/add",
        component: AdminAddOrganizations,
        name: "admin_add_organizations"
      },
      // Organizations - Edit
      {
        path: "organizations/edit/:id",
        component: AdminEditOrganizations,
        name: "admin_edit_organizations"
      },
      // Organizations - View
      {
        path: "organizations/view/:id",
        component: AdminViewOrganizations,
        name: "admin_view_organizations"
      },
      // Locations - Index
      {
        path: "locations",
        component: AdminLocations,
        name: "admin_locations"
      },
      // Locations - Add
      {
        path: "locations/add",
        component: AdminAddLocations,
        name: "admin_add_locations"
      },
      // Locations - Edit
      {
        path: "locations/edit/:id",
        component: AdminEditLocations,
        name: "admin_edit_locations"
      },
      // Locations - View
      {
        path: "locations/view/:id",
        component: AdminViewLocations,
        name: "admin_view_locations"
	  },
	  // Contacts - Index
      {
        path: "contacts",
        component: AdminContacts,
        name: "admin_contacts"
      },
      // Contacts - Add
      {
        path: "contacts/add",
        component: AdminAddContacts,
        name: "admin_add_contacts"
      },
      // Contacts - Edit
      {
        path: "contacts/edit/:id",
        component: AdminEditContacts,
        name: "admin_edit_contacts"
      },
      // File Entries - Index
      {
        path: "file_entries",
        component: AdminFileEntries,
        name: "admin_file_entries"
      },
      // File Entries - Add
      {
        path: "file_entries/add",
        component: AdminAddFileEntries,
        name: "admin_add_file_entries"
      },
      // Users - Index
      {
        path: "users",
        component: AdminUsers,
        name: "admin_users"
      },
      // Users - Add
      {
        path: "users/add",
        component: AdminAddUsers,
        name: "admin_add_users"
      },
      // Users - Edit
      {
        path: "users/edit/:id",
        component: AdminEditUsers,
        name: "admin_edit_users"
      },
      // Users - View
      {
        path: "users/view/:id",
        component: AdminViewUsers,
        name: "admin_view_users"
      },
      // Checklists - Index
      {
        path: "checklists",
        component: AdminChecklists,
        name: "admin_checklists"
      },
      // Checklist Areas - Add
      {
        path: "checklist_areas/add",
        component: AdminAddChecklistAreas,
        name: "admin_add_checklist_areas"
      },
      // Checklist Areas - Edit
      {
        path: "checklist_areas/edit/:id",
        component: AdminEditChecklistAreas,
        name: "admin_edit_checklist_areas"
      },
      // Checklist Times - Add
      {
        path: "checklist_times/add",
        component: AdminAddChecklistTimes,
        name: "admin_add_checklist_times"
      },
      // Checklist Times - Edit
      {
        path: "checklist_times/edit/:id",
        component: AdminEditChecklistTimes,
        name: "admin_edit_checklist_times"
      },
      // Checklist Categories - Add
      {
        path: "checklist_categories/add",
        component: AdminAddChecklistCategories,
        name: "admin_add_checklist_categories"
      },
      // Checklist Categories - Edit
      {
        path: "checklist_categories/edit/:id",
        component: AdminEditChecklistCategories,
        name: "admin_edit_checklist_categories"
      },
      // Checklist Items - Add
      {
        path: "checklist_items/add",
        component: AdminAddChecklistItems,
        name: "admin_add_checklist_items"
      },
      // Checklist Items - Edit
      {
        path: "checklist_items/edit/:id",
        component: AdminEditChecklistItems,
        name: "admin_edit_checklist_items"
      },
      // Manage Checklists - Index
      {
        path: "manage_checklists",
        component: AdminManageChecklists,
        name: "admin_manage_checklists"
      },
      // Manage Checklists - Add
      {
        path: "manage_checklists/add",
        component: AdminAddManageChecklists,
        name: "admin_add_manage_checklists"
      },
      // Manage Checklists - Edit
      {
        path: "manage_checklists/edit/:id",
        component: AdminEditManageChecklists,
        name: "admin_edit_manage_checklists"
      },
      // Manage Checklists - View
      {
        path: "manage_checklists/view/:id",
        component: AdminViewManageChecklists,
        name: "admin_view_manage_checklists"
      },
      // Staff Daily Checklists - Index
      {
        path: "staff_daily_checklists",
        component: AdminStaffDailyChecklists,
        name: "admin_staff_daily_checklists"
      },
      // Staff Daily Checklists - Add
      {
        path: "staff_daily_checklists/add",
        component: AdminAddStaffDailyChecklists,
        name: "admin_add_staff_daily_checklists"
      },
      // Staff Daily Checklists - View
      {
        path: "staff_daily_checklists/view/:id",
        component: AdminViewStaffDailyChecklists,
        name: "admin_view_staff_daily_checklists"
      },
      // Matrix Checklists - Index
      {
        path: "matrix_checklists",
        component: AdminMatrixChecklists,
        name: "admin_matrix_checklists"
      },
      // Matrix Checklists - Add
      {
        path: "matrix_checklists/add",
        component: AdminAddMatrixChecklists,
        name: "admin_add_matrix_checklists"
      },
      // Matrix Checklists - View
      {
        path: "matrix_checklists/view/:id",
        component: AdminViewMatrixChecklists,
        name: "admin_view_matrix_checklists"
      }
    ]
  }
];

export default routes;
