<template>
  <header class="site-header">
	  <div class="row">
		  <div class="col-sm-6">
				<img
					id="logo-desk"
					src="/assets/img/logo.png"
					alt="Smartprobe Logo"
					width="220px"
					style="position: relative; top: -10px;"
				>
				<a href="#" class="nav-toggle" @click="onNavToggle">
					<i class="icon-fa icon-fa-bars" aria-hidden="true"/>
				</a>
		  </div>
	  </div>
  </header>
</template>
<script type="text/babel">
import Auth from '../../../services/auth'

export default {
  methods: {
    onNavToggle () {
      this.$utils.toggleSidebar()
    }
  }
}
</script>
