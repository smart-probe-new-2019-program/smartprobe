<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Users</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View User</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/users" class="btn btn-dark btn-xs float-right">
                  <i class="icon-fa icon-fa-arrow-left"></i>Back
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">  
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<tbody>
									<tr> 
										<td> Firstname </td>
										<td> <b> {{userData.first_name}} </b> </td>
									</tr>
									<tr> 
										<td> Lastname </td>
										<td> <b> {{userData.last_name}} </b> </td>
									</tr>
									<tr> 
										<td> Email </td>
										<td> <b> {{userData.email}} </b> </td>
									</tr>
									<tr> 
										<td> Username </td>
										<td> <b> {{userData.username}} </b> </td>
									</tr>
									<tr> 
										<td> Role </td>
										<td> <b> {{userData.role}} </b> </td>
									</tr>
									<tr v-if="userData.role=='Manager' || userData.role=='Staff'"> 
										<td> Location </td>
										<td> <b> {{userData.location.name}} </b> </td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		  </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">

export default {
	data() {
		return {
			userData: {},
		};
	},
	mounted() {
		this.getUser();
	},
	methods: {
		getUser() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/users/' + id)
			.then(function(resp) {
				app.userData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching user data");
			});
		}
	}
};
</script>