<template>
  <div class="sidebar-left">
    <div class="sidebar-body scroll-pane">
      <!-- ADMIN Menu -->
      <div class="side-nav" v-if="user_role=='Admin'">
        <v-collapse accordion>
          <v-collapse-item active-url="/admin/dashboard">
            <router-link slot="item-title" to="/admin/dashboard">
              <i class="icon-fa icon-fa-home" />Dashboard
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/admin/probes">
            <router-link slot="item-title" to="/admin/probes">
              <i class="icon-fa icon-fa-product-hunt" />Probes
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/admin/corrective_actions">
            <router-link slot="item-title" to="/admin/corrective_actions">
              <i class="icon-fa icon-fa-pencil-square" />Corrective Actions
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-file-text-o" />Reports
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/admin/probes_logs">
              <i class="icon-fa icon-fa-circle-thin" />Probes Logs
            </router-link>
            <router-link to="/admin/temp_check_logs">
              <i class="icon-fa icon-fa-circle-thin" />Temp Check Logs
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-list-ol" />Cook-Chill
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/admin/cook_chill_checks">
              <i class="icon-fa icon-fa-circle-thin" />Manage
            </router-link>
            <router-link to="/admin/suppliers">
              <i class="icon-fa icon-fa-circle-thin" />Suppliers
            </router-link>
            <router-link to="/admin/type_of_foods">
              <i class="icon-fa icon-fa-circle-thin" />Type of Foods
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-truck" />Incoming Deliveries
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/admin/incoming_deliveries">
              <i class="icon-fa icon-fa-circle-thin" />Manage
            </router-link>
            <router-link to="/admin/incoming_deliveries_items">
              <i class="icon-fa icon-fa-circle-thin" />Items
            </router-link>
            <router-link to="/admin/suppliers">
              <i class="icon-fa icon-fa-circle-thin" />Suppliers
            </router-link>
            <router-link to="/admin/incoming_deliveries_categories">
              <i class="icon-fa icon-fa-circle-thin" />Categories
            </router-link>
            <router-link to="/admin/incoming_deliveries_type_of_products">
              <i class="icon-fa icon-fa-circle-thin" />Type of Products
            </router-link>
            <router-link to="/admin/incoming_deliveries_corrective_actions">
              <i class="icon-fa icon-fa-circle-thin" />Corrective Actions
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-check-circle-o" />Checklists
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/admin/staff_daily_checklists">
              <i class="icon-fa icon-fa-circle-thin" />Staff Daily Checklists
            </router-link>
            <router-link to="/admin/matrix_checklists">
              <i class="icon-fa icon-fa-circle-thin" />Matrix Checklists
            </router-link>
            <router-link to="/admin/checklists">
              <i class="icon-fa icon-fa-circle-thin" />Set Checklist Entries
            </router-link>
            <router-link to="/admin/manage_checklists">
              <i class="icon-fa icon-fa-circle-thin" />Manage Checklists
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/admin/file_entries">
            <router-link slot="item-title" to="/admin/file_entries">
              <i class="icon-fa icon-fa-files-o" />File Entries
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-user-secret" />Administration
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/admin/organizations">
              <i class="icon-fa icon-fa-circle-thin" />Organizations
            </router-link>
            <router-link to="/admin/locations">
              <i class="icon-fa icon-fa-circle-thin" />Locations
            </router-link>
            <router-link to="/admin/contacts">
              <i class="icon-fa icon-fa-circle-thin" />Contacts
            </router-link>
            <router-link to="/admin/users">
              <i class="icon-fa icon-fa-circle-thin" />Users
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#" @click.prevent="logout">
              <i class="icon-fa icon-fa-sign-out" /> Logout
            </a>
          </v-collapse-item>
        </v-collapse>
      </div>
      <!-- ADMIN Menu END -->

      <!-- ORGANIZER Menu -->
      <div class="side-nav" v-if="user_role=='Organizer'">
        <v-collapse accordion>
          <v-collapse-item active-url="/organizer/dashboard">
            <router-link slot="item-title" to="/organizer/dashboard">
              <i class="icon-fa icon-fa-home" />Dashboard
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/organizer/probes">
            <router-link slot="item-title" to="/organizer/probes">
              <i class="icon-fa icon-fa-product-hunt" />Probes
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/organizer/corrective_actions">
            <router-link slot="item-title" to="/organizer/corrective_actions">
              <i class="icon-fa icon-fa-pencil-square" />Corrective Actions
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-file-text-o" />Reports
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/organizer/probes_logs">
              <i class="icon-fa icon-fa-circle-thin" />Probes Logs
            </router-link>
            <!-- <router-link to="/organizer/latest_logs">
              <i class="icon-fa icon-fa-circle-thin" />Latest Logs
            </router-link>-->
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-list-ol" />Cook-Chill
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/organizer/cook_chill_checks">
              <i class="icon-fa icon-fa-circle-thin" />Manage
            </router-link>
            <router-link to="/organizer/suppliers">
              <i class="icon-fa icon-fa-circle-thin" />Suppliers
            </router-link>
            <router-link to="/organizer/type_of_foods">
              <i class="icon-fa icon-fa-circle-thin" />Type of Foods
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-truck" />Incoming Deliveries
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/organizer/incoming_deliveries">
              <i class="icon-fa icon-fa-circle-thin" />Manage
            </router-link>
            <router-link to="/organizer/incoming_deliveries_items">
              <i class="icon-fa icon-fa-circle-thin" />Items
            </router-link>
            <router-link to="/organizer/suppliers">
              <i class="icon-fa icon-fa-circle-thin" />Suppliers
            </router-link>
            <router-link to="/organizer/incoming_deliveries_categories">
              <i class="icon-fa icon-fa-circle-thin" />Categories
            </router-link>
            <router-link to="/organizer/incoming_deliveries_type_of_products">
              <i class="icon-fa icon-fa-circle-thin" />Type of Products
            </router-link>
            <router-link to="/organizer/incoming_deliveries_corrective_actions">
              <i class="icon-fa icon-fa-circle-thin" />Corrective Actions
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-check-circle-o" />Checklists
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/organizer/staff_daily_checklists">
              <i class="icon-fa icon-fa-circle-thin" />Staff Daily Checklists
            </router-link>
            <router-link to="/organizer/matrix_checklists">
              <i class="icon-fa icon-fa-circle-thin" />Matrix Checklists
            </router-link>
            <router-link to="/organizer/checklists">
              <i class="icon-fa icon-fa-circle-thin" />Set Checklist Entries
            </router-link>
            <router-link to="/organizer/manage_checklists">
              <i class="icon-fa icon-fa-circle-thin" />Manage Checklists
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/organizer/file_entries">
            <router-link slot="item-title" to="/organizer/file_entries">
              <i class="icon-fa icon-fa-files-o" />File Entries
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-user-secret" />Administration
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/organizer/locations">
              <i class="icon-fa icon-fa-circle-thin" />Locations
            </router-link>
            <router-link to="/organizer/contacts">
              <i class="icon-fa icon-fa-circle-thin" />Contacts
            </router-link>
            <router-link to="/organizer/users">
              <i class="icon-fa icon-fa-circle-thin" />Users
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#" @click.prevent="logout">
              <i class="icon-fa icon-fa-sign-out" /> Logout
            </a>
          </v-collapse-item>
        </v-collapse>
      </div>
      <!-- ORGANIZER Menu END -->

      <!-- MANAGER Menu -->
      <div class="side-nav" v-if="user_role=='Manager'">
        <v-collapse accordion>
          <v-collapse-item active-url="/manager/dashboard">
            <router-link slot="item-title" to="/manager/dashboard">
              <i class="icon-fa icon-fa-home" />Dashboard
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/manager/probes">
            <router-link slot="item-title" to="/manager/probes">
              <i class="icon-fa icon-fa-product-hunt" />Probes
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-file-text-o" />Reports
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/manager/probes_logs">
              <i class="icon-fa icon-fa-circle-thin" />Probes Logs
            </router-link>
            <!-- <router-link to="/manager/latest_logs">
              <i class="icon-fa icon-fa-circle-thin" />Latest Logs
            </router-link>-->
          </v-collapse-item>

          <v-collapse-item active-url="/manager/file_entries">
            <router-link slot="item-title" to="/manager/file_entries">
              <i class="icon-fa icon-fa-files-o" />File Entries
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#" @click.prevent="logout">
              <i class="icon-fa icon-fa-sign-out" /> Logout
            </a>
          </v-collapse-item>
        </v-collapse>
      </div>
      <!-- MANAGER Menu END -->

      <!-- STAFF Menu -->
      <div class="side-nav" v-if="user_role=='Staff'">
        <v-collapse accordion>
          <v-collapse-item active-url="/staff/dashboard">
            <router-link slot="item-title" to="/staff/dashboard">
              <i class="icon-fa icon-fa-home" />Dashboard
            </router-link>
          </v-collapse-item>

          <!-- <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-file-text-o" />Reports
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/manager/latest_logs">
              <i class="icon-fa icon-fa-circle-thin" />Latest Logs
            </router-link>
          </v-collapse-item>-->

          <v-collapse-item active-url="/staff/corrective_actions">
            <router-link slot="item-title" to="/staff/corrective_actions">
              <i class="icon-fa icon-fa-pencil-square" />Corrective Actions
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-list-ol" />Cook-Chill
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/staff/cook_chill_checks">
              <i class="icon-fa icon-fa-circle-thin" />Manage
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-truck" />Incoming Deliveries
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/staff/incoming_deliveries">
              <i class="icon-fa icon-fa-circle-thin" />Manage
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-check-circle-o" />Checklists
              <span class="icon-fa arrow icon-fa-fw" />
            </a>
            <router-link to="/staff/staff_daily_checklists">
              <i class="icon-fa icon-fa-circle-thin" />Staff Daily Checklists
            </router-link>
            <router-link to="/staff/matrix_checklists">
              <i class="icon-fa icon-fa-circle-thin" />Matrix Checklists
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/staff/file_entries">
            <router-link slot="item-title" to="/staff/file_entries">
              <i class="icon-fa icon-fa-files-o" />File Entries
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url>
            <a slot="item-title" href="#" @click.prevent="logout">
              <i class="icon-fa icon-fa-sign-out" /> Logout
            </a>
          </v-collapse-item>
        </v-collapse>
      </div>
      <!-- STAFF Menu END -->
    </div>
  </div>
</template>

<script type="text/babel">
import Auth from "../../../services/auth";

export default {
  data() {
    return {
      user_role: localStorage.getItem("user.role")
    };
  },
  mounted() {},
  methods: {
    onNavToggle() {
      this.$utils.toggleSidebar();
    },
    logout() {
      Auth.logout().then(() => {
        this.$router.replace("/login");
      });
    }
  }
};
</script>