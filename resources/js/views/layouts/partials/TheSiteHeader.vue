<template>
  <header class="site-header">
	  <div class="row">
		  <div class="col">
				<img @click="onNavToggle"
					id="logo-desk"
					src="/assets/img/logo.png"
					alt="Smartprobe Logo"
					width="220px"
					style="position: relative; top: -10px;"
				>
		  </div>
		  <div class="col">
			  <h5 class="float-right" style="color: white; position: relative; top: 50%; transform: translateY(-50%);">Hi, {{first_name}}!!</h5>
		  </div>
	  </div>
  </header>
</template>
<script type="text/babel">
import Auth from '../../../services/auth'

export default {
  data() {
	return {
		first_name: localStorage.getItem("user.first_name"),
	}
  }, 
  methods: {
    onNavToggle () {
      this.$utils.toggleSidebar()
    }
  }
}
</script>
