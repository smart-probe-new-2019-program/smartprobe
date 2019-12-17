<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Incoming Deliveries</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View a Delivery</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/staff/incoming_deliveries" class="btn btn-dark btn-xs float-right">
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
										<td> Item </td>
										<td> <b> {{incomingDeliveryData.item.name}} </b> </td>
									</tr>
									<tr> 
										<td> Staff </td>
										<td> <b> {{incomingDeliveryData.user.full_name}} </b> </td>
									</tr>
									<tr> 
										<td> Supplier </td>
										<td> <b> {{incomingDeliveryData.supplier.name}} </b> </td>
									</tr>
									<tr> 
										<td> Category </td>
										<td> <b> {{incomingDeliveryData.category.name}} </b> </td>
									</tr>
									<tr> 
										<td> Type of Product </td>
										<td> <b> {{incomingDeliveryData.type_of_product.name}} </b> </td>
									</tr>
									<tr> 
										<td> Tested Time </td>
										<td> <b> {{incomingDeliveryData.tested_time}} </b> </td>
									</tr>
									<tr> 
										<td> Package Intact </td>
										<td> <b> {{incomingDeliveryData.package_intact}} </b> </td>
									</tr>
									<tr> 
										<td> Batch Number </td>
										<td> <b> {{incomingDeliveryData.batch_number}} </b> </td>
									</tr>
									<tr> 
										<td> Comment </td>
										<td> <b> {{incomingDeliveryData.comment}} </b> </td>
									</tr>
									<tr> 
										<td> Corrective Action </td>
										<td> <b> {{incomingDeliveryData.corrective_action.name}} </b> </td>
									</tr>
									<tr> 
										<td> Probe </td>
										<td> <b> {{incomingDeliveryData.probe.name}} </b> </td>
									</tr>
									<tr> 
										<td> Current Temperature </td>
										<td> <b> {{incomingDeliveryData.current_temperature}} {{incomingDeliveryData.current_temperature_unit}} </b> </td>
									</tr>
									<tr> 
										<td> Status </td>
										<td> <b> {{incomingDeliveryData.status}} </b> </td>
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
			incomingDeliveryData: {},
		};
	},
	mounted() {
		this.getIncomingDelivery();
	},
	methods: {
		getIncomingDelivery() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/incoming_deliveries/' + id)
			.then(function(resp) {
				app.incomingDeliveryData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching delivery data");
			});
		}
	}
};
</script>