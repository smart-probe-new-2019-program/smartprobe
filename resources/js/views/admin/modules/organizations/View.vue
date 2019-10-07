<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Organizations</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View an Organization</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/organizations" class="btn btn-dark btn-xs float-right">
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
										<td> Name </td>
										<td> <b> {{organizationData.name}} </b> </td>
									</tr>
									<tr> 
										<td> Description </td>
										<td> <b> {{organizationData.description}} </b> </td>
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
			organizationData: {},
		};
	},
	mounted() {
		this.getOrganization();
	},
	methods: {
		getOrganization() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/organizations/' + id)
			.then(function(resp) {
				app.organizationData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching organization data");
			});
		}
	}
};
</script>