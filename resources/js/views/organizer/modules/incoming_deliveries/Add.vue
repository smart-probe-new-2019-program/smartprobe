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
                <h5>Add a Delivery</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/incoming_deliveries" class="btn btn-dark btn-xs float-right">
                  <i class="icon-fa icon-fa-arrow-left"></i>Back
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
			<form @submit.prevent="saveForm">        
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Item</label>
							<select class="form-control" v-model.trim="incomingDeliveryData.item_id" ref="item_id" required>
								<option v-for="item in items" :value="item.id">
									{{item.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Staff</label>
							<select class="form-control" v-model.trim="incomingDeliveryData.user_id" ref="user_id" required>
								<option v-for="user in users" :value="user.id">
									{{user.full_name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Supplier</label>
							<select class="form-control" v-model.trim="incomingDeliveryData.supplier_id" ref="supplier_id" required>
								<option v-for="supplier in suppliers" :value="supplier.id">
									{{supplier.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Category</label>
							<select class="form-control" v-model.trim="incomingDeliveryData.category_id" ref="category_id" required>
								<option v-for="category in categories" :value="category.id">
									{{category.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Type of Product</label>
							<select class="form-control" v-model.trim="incomingDeliveryData.type_of_product_id" ref="type_of_product_id" required>
								<option v-for="type_of_product in type_of_products" :value="type_of_product.id">
									{{type_of_product.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Tested Time</label>
							<flat-pickr class="form-control" v-model.trim="incomingDeliveryData.tested_time" :config="flatPickrOptions" ref="tested_time"></flat-pickr>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Package Intact</label>
							<select class="form-control" v-model="incomingDeliveryData.package_intact" ref="package_intact" required>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Batch Number</label>
							<input type="text" v-model.trim="incomingDeliveryData.batch_number" class="form-control" ref="batch_number" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Comment</label>
							<textarea v-model.trim="incomingDeliveryData.comment" class="form-control" rows="3" ref="comment"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Corrective Action</label>
							<select class="form-control" v-model.trim="incomingDeliveryData.corrective_action_id" ref="corrective_action_id" required>
								<option v-for="corrective_action in corrective_actions" :value="corrective_action.id">
									{{corrective_action.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Probe</label>
							<select class="form-control" v-model.trim="incomingDeliveryData.probe_id" ref="probe_id" required>
								<option v-for="probe in probes" :value="probe.id">
									{{probe.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 form-group">
							<label class="control-label">Current Temperature</label>
							<input type="text" v-model.trim="incomingDeliveryData.current_temperature" class="form-control" ref="current_temperature">
						</div>
						<div class="col-sm-2 form-group">
							<label class="control-label">Unit</label>
							<select class="form-control" v-model="incomingDeliveryData.current_temperature_unit" ref="current_temperature_unit" required>
								<option value="Celsius">Celsius</option>
								<option value="Fahrenheit">Fahrenheit</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Status</label>
							<select class="form-control" v-model="incomingDeliveryData.status" ref="status" required>
								<option value="Accept">Accept</option>
								<option value="Reject">Reject</option>
							</select>
						</div>
					</div>
				</div>

				<div class="col-xs-12 form-group">
					<button class="btn btn-sm btn-success"><i class="icon-fa icon-fa-plus-circle"/> Create</button>
				</div>
			</form>
		  </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
	components: {flatPickr},
	data() {
		return {
			flatPickrOptions: {
				enableTime: true,
				noCalendar: true,
				dateFormat: "H:i",
				time_24hr: true
			},
			incomingDeliveryData: {
				organization_id: localStorage.getItem("user.organization_id"),
				item_id: "",
				user_id: "",
				supplier_id: "",
				category_id: "",
				type_of_product_id: "",
				tested_time: "",
				package_intact: "",
				batch_number: "",
				comment: "",
				corrective_action_id: "",
				probe_id: "",
				current_temperature: "",
				current_temperature_unit: "",
				status: "",
				created_by: localStorage.getItem("user.id"),
				updated_by: localStorage.getItem("user.id")
			},
			items: [],
			users: [],
			suppliers: [],
			categories: [],
			type_of_products: [],
			corrective_actions: [],
			probes: [],	
		};
	},
	mounted() {
		this.getNeededDropdowns();
		toastr.options = {
			closeButton: true,
			debug: false,
			positionClass: 'toast-top-right',
			onclick: null,
			showDuration: '1000',
			hideDuration: '1000',
			timeOut: '5000',
			extendedTimeOut: '1000',
			showEasing: 'swing',
			hideEasing: 'linear',
			showMethod: 'fadeIn',
			hideMethod: 'fadeOut'
		}
	},
	methods: {
		getNeededDropdowns() {
			let app = this;

			app.incomingDeliveryData.item_id = null;
			app.incomingDeliveryData.user_id = null;
			app.incomingDeliveryData.supplier_id = null;
			app.incomingDeliveryData.category_id = null;
			app.incomingDeliveryData.type_of_product_id = null;
			app.incomingDeliveryData.corrective_action_id = null;
			app.incomingDeliveryData.probe_id = null;

			app.getIncomingDeliveriesItemsByOrganizationID();
			app.getUsersByOrganizationID();
			app.getSuppliersByOrganizationID();
			app.getIncomingDeliveriesCategoriesByOrganizationID();
			app.getIncomingDeliveriesTypeOfProductsByOrganizationID();
			app.getIncomingDeliveriesCorrectiveActionsByOrganizationID();
			app.getProbesByOrganizationID();
		},
		getIncomingDeliveriesItemsByOrganizationID() {
			let app = this;
			axios.get('/api/admin/incoming_deliveries_items/getIncomingDeliveriesItemsByOrganizationID/'+ app.incomingDeliveryData.organization_id)
			.then(function(resp) {
				app.items = resp.data;
			})
			.catch(function() {
				console.log("Error fetching items");
			});
		},
		getUsersByOrganizationID() {
			let app = this;
			axios.get('/api/admin/users/getUsersByOrganizationID/'+ app.incomingDeliveryData.organization_id)
			.then(function(resp) {
				app.users = resp.data;
			})
			.catch(function() {
				console.log("Error fetching users");
			});
		},
		getSuppliersByOrganizationID() {
			let app = this;
			axios.get('/api/admin/suppliers/getSuppliersByOrganizationID/'+ app.incomingDeliveryData.organization_id)
			.then(function(resp) {
				app.suppliers = resp.data;
			})
			.catch(function() {
				console.log("Error fetching suppliers");
			});
		},
		getIncomingDeliveriesCategoriesByOrganizationID() {
			let app = this;
			axios.get('/api/admin/incoming_deliveries_categories/getIncomingDeliveriesCategoriesByOrganizationID/'+ app.incomingDeliveryData.organization_id)
			.then(function(resp) {
				app.categories = resp.data;
			})
			.catch(function() {
				console.log("Error fetching categories");
			});
		},
		getIncomingDeliveriesTypeOfProductsByOrganizationID() {
			let app = this;
			axios.get('/api/admin/id_type_of_products/getIncomingDeliveriesTypeOfProductsByOrganizationID/'+ app.incomingDeliveryData.organization_id)
			.then(function(resp) {
				app.type_of_products = resp.data;
			})
			.catch(function() {
				console.log("Error fetching type of products");
			});
		},
		getIncomingDeliveriesCorrectiveActionsByOrganizationID() {
			let app = this;
			axios.get('/api/admin/id_corrective_actions/getIncomingDeliveriesCorrectiveActionsByOrganizationID/'+ app.incomingDeliveryData.organization_id)
			.then(function(resp) {
				app.corrective_actions = resp.data;
			})
			.catch(function() {
				console.log("Error fetching corrective actions");
			});
		},
		getProbesByOrganizationID() {
			let app = this;
			axios.get('/api/admin/probes/getProbesByOrganizationID/'+ app.incomingDeliveryData.organization_id)
			.then(function(resp) {
				app.probes = resp.data;
			})
			.catch(function() {
				console.log("Error fetching probes");
			});
		},
		saveForm() {
			let app = this;
		
			axios.post('/api/admin/incoming_deliveries', app.incomingDeliveryData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while adding the delivery. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/organizer/incoming_deliveries');
					toastr['success']('New delivery added!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
		}
	}
};
</script>
