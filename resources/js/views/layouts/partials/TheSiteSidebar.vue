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

		  <v-collapse-item active-url="/admin/organizations">
			<router-link
			slot="item-title"
			to="/admin/organizations">
			<i class="icon-fa icon-fa-sitemap"/>Organizations
			</router-link>
		  </v-collapse-item>

		  <v-collapse-item active-url="/admin/users">
			<router-link
			slot="item-title"
			to="/admin/users">
			<i class="icon-fa icon-fa-users"/>Users
			</router-link>
		  </v-collapse-item>

		  <!-- <v-collapse-item active-url="">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-list"/>Tests
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>
            <router-link to="/admin/production_tests">
              <i class="icon-fa icon-fa-circle-o"/>Production
            </router-link>
			<router-link to="/admin/packaging_tests">
              <i class="icon-fa icon-fa-circle-o"/>Packaging
            </router-link>
			<router-link to="/admin/boxing">
              <i class="icon-fa icon-fa-circle-o"/>Boxing
            </router-link>
			<router-link to="/admin/quality_tests">
              <i class="icon-fa icon-fa-circle-o"/>Quality
            </router-link>
			<router-link to="/admin/verifications">
              <i class="icon-fa icon-fa-circle-o"/>Verification
            </router-link>
          </v-collapse-item> -->

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