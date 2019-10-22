<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Cook Chill Checks</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View a Cook Chill Check</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/cook_chill_checks" class="btn btn-dark btn-xs float-right">
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
										<td> Organization </td>
										<td> <b> {{cookChillCheckData.organization.name}} </b> </td>
									</tr>
									<tr> 
										<td> Staff </td>
										<td> <b> {{cookChillCheckData.user.full_name}} </b> </td>
									</tr>
									<tr> 
										<td> Supplier </td>
										<td> <b> {{cookChillCheckData.supplier.name}} </b> </td>
									</tr>
									<tr> 
										<td> Type of Food </td>
										<td> <b> {{cookChillCheckData.type_of_food.name}} </b> </td>
									</tr>
									<tr> 
										<td> Start Time </td>
										<td> <b> {{cookChillCheckData.start_time}} </b> </td>
									</tr>
									<tr> 
										<td> End Time </td>
										<td> <b> {{cookChillCheckData.end_time}} </b> </td>
									</tr>
									<tr> 
										<td> Batch Number </td>
										<td> <b> {{cookChillCheckData.batch_number}} </b> </td>
									</tr>
									<tr> 
										<td> Comment </td>
										<td> <b> {{cookChillCheckData.comment}} </b> </td>
									</tr>
									<tr> 
										<td> Probe </td>
										<td> <b> {{cookChillCheckData.probe.name}} </b> </td>
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
			cookChillCheckData: {},
		};
	},
	mounted() {
		this.getCookChillCheck();
	},
	methods: {
		getCookChillCheck() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/cook_chill_checks/' + id)
			.then(function(resp) {
				app.cookChillCheckData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching cook chill check data");
			});
		}
	}
};
</script>