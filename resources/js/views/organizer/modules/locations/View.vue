<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Locations</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View a Location</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/locations" class="btn btn-dark btn-xs float-right">
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
										<td> <b> {{locationData.name}} </b> </td>
									</tr>
									<tr> 
										<td> Address </td>
										<td> <b> {{locationData.address}} </b> </td>
									</tr>
									<tr> 
										<td> City </td>
										<td> <b> {{locationData.city}} </b> </td>
									</tr>
									<tr> 
										<td> Country </td>
										<td> <b> {{locationData.country}} </b> </td>
									</tr>
									<tr> 
										<td> State </td>
										<td> <b> {{locationData.state}} </b> </td>
									</tr>
									<tr> 
										<td> Zip Code </td>
										<td> <b> {{locationData.zip_code}} </b> </td>
									</tr>
									<tr> 
										<td> Email </td>
										<td> <b> {{locationData.email}} </b> </td>
									</tr>
									<tr> 
										<td> Office Phone </td>
										<td> <b> {{locationData.office_phone}} </b> </td>
									</tr>
									<tr> 
										<td> Office Fax </td>
										<td> <b> {{locationData.office_fax}} </b> </td>
									</tr>
									<tr> 
										<td> Mobile Phone </td>
										<td> <b> {{locationData.mobile_phone}} </b> </td>
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
			locationData: {},
		};
	},
	mounted() {
		this.getLocation();
	},
	methods: {
		getLocation() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/locations/' + id)
			.then(function(resp) {
				app.locationData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching location data");
			});
		}
	}
};
</script>