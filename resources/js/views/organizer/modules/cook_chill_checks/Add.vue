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
                <h5>Add a Cook Chill Check</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/cook_chill_checks" class="btn btn-dark btn-xs float-right">
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
							<label class="control-label">Staff</label>
							<select class="form-control" v-model.trim="cookChillCheckData.user_id" ref="user_id" required>
								<option v-for="user in users" :value="user.id">
									{{user.full_name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Supplier</label>
							<select class="form-control" v-model.trim="cookChillCheckData.supplier_id" ref="supplier_id" required>
								<option v-for="supplier in suppliers" :value="supplier.id">
									{{supplier.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Type of Food</label>
							<select class="form-control" v-model.trim="cookChillCheckData.type_of_food_id" ref="type_of_food_id" required>
								<option v-for="type_of_food in type_of_foods" :value="type_of_food.id">
									{{type_of_food.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Start Time</label>
							<flat-pickr class="form-control" v-model.trim="cookChillCheckData.start_time" :config="flatPickrOptions" ref="start_time"></flat-pickr>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">End Time</label>
							<flat-pickr class="form-control" v-model.trim="cookChillCheckData.end_time" :config="flatPickrOptions" ref="end_time"></flat-pickr>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Batch Number</label>
							<input type="text" v-model.trim="cookChillCheckData.batch_number" class="form-control" ref="batch_number" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Comment</label>
							<textarea v-model.trim="cookChillCheckData.comment" class="form-control" rows="3" ref="comment" required/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Probe</label>
							<select class="form-control" v-model.trim="cookChillCheckData.probe_id" ref="probe_id" required>
								<option v-for="probe in probes" :value="probe.id">
									{{probe.name}}
								</option>
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
			cookChillCheckData: {
				user_id: "",
				supplier_id: "",
				type_of_food_id: "",
				start_time: "",
				end_time: "",
				batch_number: "",
				comment: "",
				organization_id: localStorage.getItem("user.organization_id"),
				probe_id: "",
				created_by: localStorage.getItem("user.id"),
				updated_by: localStorage.getItem("user.id")
			},
			users: [],
			suppliers: [],
			type_of_foods: [],
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

			app.cookChillCheckData.user_id = null;
			app.cookChillCheckData.supplier_id = null;
			app.cookChillCheckData.type_of_food_id = null;
			app.cookChillCheckData.probe_id = null;

			app.getUsersByOrganizationID();
			app.getSuppliersByOrganizationID();
			app.getTypeOfFoodsByOrganizationID();
			app.getProbesByOrganizationID();
		},
		getUsersByOrganizationID() {
			let app = this;
			axios.get('/api/admin/users/getUsersByOrganizationID/'+ app.cookChillCheckData.organization_id)
			.then(function(resp) {
				app.users = resp.data;
			})
			.catch(function() {
				console.log("Error fetching users");
			});
		},
		getSuppliersByOrganizationID() {
			let app = this;
			axios.get('/api/admin/suppliers/getSuppliersByOrganizationID/'+ app.cookChillCheckData.organization_id)
			.then(function(resp) {
				app.suppliers = resp.data;
			})
			.catch(function() {
				console.log("Error fetching suppliers");
			});
		},
		getTypeOfFoodsByOrganizationID() {
			let app = this;
			axios.get('/api/admin/type_of_foods/getTypeOfFoodsByOrganizationID/'+ app.cookChillCheckData.organization_id)
			.then(function(resp) {
				app.type_of_foods = resp.data;
			})
			.catch(function() {
				console.log("Error fetching type of foods");
			});
		},
		getProbesByOrganizationID() {
			let app = this;
			axios.get('/api/admin/probes/getProbesByOrganizationID/'+ app.cookChillCheckData.organization_id)
			.then(function(resp) {
				app.probes = resp.data;
			})
			.catch(function() {
				console.log("Error fetching probes");
			});
		},
		saveForm() {
			let app = this;
		
			axios.post('/api/admin/cook_chill_checks', app.cookChillCheckData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while adding the entry. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/organizer/cook_chill_checks');
					toastr['success']('New entry added!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
		}
	}
};
</script>
