<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Probes</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Add a Probe</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/probes" class="btn btn-dark btn-xs float-right">
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
							<label class="control-label">Serial Number</label>
							<input type="text" v-model.trim="probeData.serial_number" class="form-control" ref="serial_number" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Name</label>
							<input type="text" v-model.trim="probeData.name" class="form-control" ref="name" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Cooling Device</label>
							<select class="form-control" v-model="probeData.cooling_device" ref="cooling_device" required>
								<option value="Bar Freezer Food">Bar Freezer Food</option>
								<option value="Bar Fridge Food">Bar Fridge Food</option>
								<option value="Bench Fridge">Bench Fridge</option>
								<option value="Chilled Packing Room">Chilled Packing Room</option>
								<option value="Coolroom">Coolroom</option>
								<option value="Dishwasher">Dishwasher</option>
								<option value="Domestic Fridge/Freezer">Domestic Fridge/Freezer</option>
								<option value="Draw Fridge U/bench">Draw Fridge U/bench</option>
								<option value="Egg Vat">Egg Vat</option>
								<option value="External Silicon Sensor">External Silicon Sensor</option>
								<option value="Food Display Cold">Food Display Cold</option>
								<option value="Food Display Hot">Food Display Hot</option>
								<option value="Freezer Chest">Freezer Chest</option>
								<option value="Freezer Open Display">Freezer Open Display</option>
								<option value="Freezer Room">Freezer Room</option>
								<option value="Freezer Upright">Freezer Upright</option>
								<option value="Fridge Bench Type">Fridge Bench Type</option>
								<option value="Fridge Open Display">Fridge Open Display</option>
								<option value="Fridge Upright">Fridge Upright</option>
								<option value="Fridge Vaccine">Fridge Vaccine</option>
								<option value="Hot Box Food">Hot Box Food</option>
								<option value="IT Server Room">IT Server Room</option>
								<option value="Lairage Liquid Chlorine Chiller">Lairage Liquid Chlorine Chiller</option>
								<option value="Meat Probe">Meat Probe</option>
								<option value="Meat Spike Probe">Meat Spike Probe</option>
								<option value="Medi Bar Fridge">Medi Bar Fridge</option>
								<option value="Oven">Oven</option>
								<option value="Pasteuriser Hot">Pasteuriser Hot</option>
								<option value="Room">Room</option>
								<option value="Truck Logger Fridge">Truck Logger Fridge</option>							
								<option value="Other">Other</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Temperature Unit</label>
							<select class="form-control" v-model="probeData.temperature_unit" ref="temperature_unit" required>
								<option value="Celsius">Celsius</option>
								<option value="Fahrenheit">Fahrenheit</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">High Temperature Warning</label>
							<input type="text" v-model.trim="probeData.temperature_warning_high" class="form-control" ref="temperature_warning_high" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Low Temperature Warning</label>
							<input type="text" v-model.trim="probeData.temperature_warning_low" class="form-control" ref="temperature_warning_low" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">High Temperature Alert</label>
							<input type="text" v-model.trim="probeData.temperature_alert_high" class="form-control" ref="temperature_alert_high" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Low Temperature Alert</label>
							<input type="text" v-model.trim="probeData.temperature_alert_low" class="form-control" ref="temperature_alert_low" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Minimum Voltage</label>
							<input type="text" v-model.trim="probeData.minimum_voltage" class="form-control" ref="minimum_voltage" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Probe Type</label>
							<select class="form-control" v-model="probeData.probe_type" ref="probe_type" required>
								<option value="Fridge/Freezer Probe">Fridge/Freezer Probe</option>
								<option value="Food Probe">Food Probe</option>
								<option value="Humidity Probe">Humidity Probe</option>
							</select>
						</div>
					</div>
					<div class="row" v-if="probeData.probe_type=='Humidity Probe'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Humidity High Warning</label>
							<input type="text" v-model.trim="probeData.humidity_warning_high" class="form-control" ref="humidity_warning_high">
						</div>
					</div>
					<div class="row" v-if="probeData.probe_type=='Humidity Probe'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Humidity Low Warning</label>
							<input type="text" v-model.trim="probeData.humidity_warning_low" class="form-control" ref="humidity_warning_low">
						</div>
					</div>
					<div class="row" v-if="probeData.probe_type=='Humidity Probe'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Humidity High Alert</label>
							<input type="text" v-model.trim="probeData.humidity_alert_high" class="form-control" ref="humidity_alert_high">
						</div>
					</div>
					<div class="row" v-if="probeData.probe_type=='Humidity Probe'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Humidity Low Alert</label>
							<input type="text" v-model.trim="probeData.humidity_alert_low" class="form-control" ref="humidity_alert_low">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Next Calibration Date</label>
							<datepicker v-model="probeData.next_calibration_date" :format="format" input-class="form-control"  ref="next_calibration_date"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 form-group">
							<label class="control-label">Frequency To Check Temperatures</label>
							<input type="text" v-model.trim="probeData.frequency_to_check_temperatures_value" class="form-control" ref="frequency_to_check_temperatures_value">
						</div>
						<div class="col-sm-2 form-group">
							<label class="control-label">Unit</label>
							<select class="form-control" v-model="probeData.frequency_to_check_temperatures_unit" ref="frequency_to_check_temperatures_unit" required>
								<option value="Seconds">Seconds</option>
								<option value="Minutes">Minutes</option>
								<option value="Hours">Hours</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 form-group">
							<label class="control-label">Alarm Time</label>
							<input type="text" v-model.trim="probeData.alarm_time_value" class="form-control" ref="alarm_time_value">
						</div>
						<div class="col-sm-2 form-group">
							<label class="control-label">Unit</label>
							<select class="form-control" v-model="probeData.alarm_time_unit" ref="alarm_time_unit" required>
								<option value="Seconds">Seconds</option>
								<option value="Minutes">Minutes</option>
								<option value="Hours">Hours</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Default Sensor</label>
							<select class="form-control" v-model="probeData.default_sensor" ref="default_sensor" required>
								<option value="Sensor 1">Sensor 1</option>
								<option value="Sensor 2">Sensor 2</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Status</label>
							<select class="form-control" v-model="probeData.status" ref="status" required>
								<option value="New">New</option>
								<option value="Active">Active</option>
								<option value="Inactive">Inactive</option>
								<option value="Deleted">Deleted</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Configured</label>
							<select class="form-control" v-model="probeData.is_configured" ref="is_configured" required>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Monitored</label>
							<select class="form-control" v-model="probeData.is_monitored" ref="is_monitored" required>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
					<div class="row" v-if="probeData.is_monitored=='Yes'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Online Monitoring Date</label>
							<datepicker v-model="probeData.online_monitoring_date" :format="format" input-class="form-control"  ref="online_monitoring_date" />
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Location</label>
							<select class="form-control" v-model="probeData.location_id" ref="location_id" required>
								<option v-for="location in locations" :value="location.id">
									{{location.name}}
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
import Datepicker from 'vuejs-datepicker'

export default {
	components: {
		Datepicker
	},
	data() {
		return {
			probeData: {
				organization_id: localStorage.getItem("user.organization_id"),
				created_by: localStorage.getItem("user.id"),
				updated_by: localStorage.getItem("user.id")
			},
			locations: [],
			format: 'yyyy-MM-dd',
		};
	},
	mounted() {
		this.getLocations();
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
		getLocations() {
			let app = this;
			axios.get('/api/admin/locations/getLocationsByOrganizationID/' + app.probeData.organization_id)
			.then(function(resp) {
				app.locations = resp.data;
			})
			.catch(function() {
				console.log("Error fetching locations");
			});
		},
		saveForm() {
			let app = this;
		
			axios.post('/api/admin/probes', app.probeData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while adding the probe. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/organizer/probes');
					toastr['success']('New probe added!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
		}
	}
};
</script>
