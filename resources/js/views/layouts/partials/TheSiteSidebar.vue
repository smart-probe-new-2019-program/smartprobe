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

		  <v-collapse-item active-url="">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-list-alt"/>Actions
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>
			<router-link to="/admin/corrective_action">
              <i class="icon-fa icon-fa-circle-thin"/>Corrective Action
            </router-link>
			<router-link to="/admin/cook_chill_check">
              <i class="icon-fa icon-fa-circle-thin"/>Cook-Chill-Check
            </router-link>
			<router-link to="/admin/incoming_delivery">
              <i class="icon-fa icon-fa-circle-thin"/>Incoming Delivery
            </router-link>
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