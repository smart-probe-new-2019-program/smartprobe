<template>
  <div class="sidebar-left">
    <div class="sidebar-body scroll-pane">
      <div class="side-nav">
        <v-collapse accordion>
          <v-collapse-item active-url="/admin/dashboard">
			<router-link
			slot="item-title"
			to="/admin/dashboard">
			<i class="icon-fa icon-fa-home"/>Dashboard
			</router-link>
		  </v-collapse-item>

		  <v-collapse-item active-url="/admin/probes">
			<router-link
			slot="item-title"
			to="/admin/probes">
			<i class="icon-fa icon-fa-product-hunt"/>Probes
			</router-link>
		  </v-collapse-item>

		  <v-collapse-item active-url="/admin/corrective_actions">
			<router-link
			slot="item-title"
			to="/admin/corrective_actions">
			<i class="icon-fa icon-fa-pencil-square"/>Corrective Actions
			</router-link>
		  </v-collapse-item>

		 <v-collapse-item active-url="">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-file-text-o"/>Reports
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>
			<router-link to="/admin/probes_logs">
              <i class="icon-fa icon-fa-circle-thin"/>Probes Logs
            </router-link>
          </v-collapse-item>

		  <v-collapse-item active-url="">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-list-ol"/>Cook-Chill
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>
			<router-link to="/admin/cook_chill_checks">
              <i class="icon-fa icon-fa-circle-thin"/>Manage
            </router-link>
			<router-link to="/admin/suppliers">
              <i class="icon-fa icon-fa-circle-thin"/>Suppliers
            </router-link>
			<router-link to="/admin/type_of_foods">
              <i class="icon-fa icon-fa-circle-thin"/>Type of Foods
            </router-link>
          </v-collapse-item>

		  <v-collapse-item active-url="">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-truck"/>Incoming Deliveries
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>
			<router-link to="/admin/incoming_deliveries">
              <i class="icon-fa icon-fa-circle-thin"/>Manage
            </router-link>
			<router-link to="/admin/incoming_deliveries_items">
              <i class="icon-fa icon-fa-circle-thin"/>Items
            </router-link>
			<router-link to="/admin/suppliers">
              <i class="icon-fa icon-fa-circle-thin"/>Suppliers
            </router-link>
			<router-link to="/admin/incoming_deliveries_categories">
              <i class="icon-fa icon-fa-circle-thin"/>Categories
            </router-link>
			<router-link to="/admin/incoming_deliveries_type_of_products">
              <i class="icon-fa icon-fa-circle-thin"/>Type of Products
            </router-link>
			<router-link to="/admin/incoming_deliveries_corrective_actions">
              <i class="icon-fa icon-fa-circle-thin"/>Corrective Actions
            </router-link>
          </v-collapse-item>

		  <v-collapse-item active-url="">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-check-circle-o"/>Checklists
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>
			<router-link to="/admin/staff_daily_checklists">
              <i class="icon-fa icon-fa-circle-thin"/>Staff Daily Checklists
            </router-link>
			<router-link to="/admin/matrix_checklists">
              <i class="icon-fa icon-fa-circle-thin"/>Matrix Checklists
            </router-link>
          </v-collapse-item>

		  <v-collapse-item active-url="">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-user-secret"/>Administration
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>
			<router-link to="/admin/organizations">
              <i class="icon-fa icon-fa-circle-thin"/>Organizations
            </router-link>
			<router-link to="/admin/locations">
              <i class="icon-fa icon-fa-circle-thin"/>Locations
            </router-link>
            <router-link to="/admin/users">
              <i class="icon-fa icon-fa-circle-thin"/>Users
            </router-link>
			<router-link to="/admin/checklists">
              <i class="icon-fa icon-fa-circle-thin"/>Set Checklist Entries
            </router-link>
			<router-link to="/admin/manage_checklists">
              <i class="icon-fa icon-fa-circle-thin"/>Manage Checklists
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="">
            <a slot="item-title" href="#" @click.prevent="logout">
              <i class="icon-fa icon-fa-sign-out"/> Logout
            </a>
          </v-collapse-item>
        </v-collapse>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import Auth from '../../../services/auth'

export default {
  methods: {
    onNavToggle () {
      this.$utils.toggleSidebar()
    },
    logout () {
      Auth.logout().then(() => {
        this.$router.replace('/login')
      })
    }
  }
}
</script>