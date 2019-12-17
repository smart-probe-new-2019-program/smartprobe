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
                <h5>View a Probe</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/probes" class="btn btn-dark btn-xs float-right">
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
										<td> Serial Number </td>
										<td> <b> {{probeData.serial_number}} </b> </td>
									</tr>
									<tr> 
										<td> Name </td>
										<td> <b> {{probeData.name}} </b> </td>
									</tr>
									<tr> 
										<td> Cooling Device </td>
										<td> <b> {{probeData.cooling_device}} </b> </td>
									</tr>
									<tr> 
										<td> Temperature Unit </td>
										<td> <b> {{probeData.temperature_unit}} </b> </td>
									</tr>
									<tr> 
										<td> High Temperature Warning </td>
										<td> <b> {{probeData.temperature_warning_high}} </b> </td>
									</tr>
									<tr> 
										<td> Low Temperature Warning </td>
										<td> <b> {{probeData.temperature_warning_low}} </b> </td>
									</tr>
									<tr> 
										<td> High Temperature Alert </td>
										<td> <b> {{probeData.temperature_alert_high}} </b> </td>
									</tr>
									<tr> 
										<td> Low Temperature Alert </td>
										<td> <b> {{probeData.temperature_alert_low}} </b> </td>
									</tr>
									<tr> 
										<td> Minimum Voltage </td>
										<td> <b> {{probeData.minimum_voltage}} </b> </td>
									</tr>
									<tr> 
										<td> Probe Type </td>
										<td> <b> {{probeData.probe_type}} </b> </td>
									</tr>
									<tr v-if="probeData.probe_type=='Humidity Probe'"> 
										<td> Humidity High Warning </td>
										<td> <b> {{probeData.humidity_warning_high}} </b> </td>
									</tr>
									<tr v-if="probeData.probe_type=='Humidity Probe'"> 
										<td> Humidity Low Warning </td>
										<td> <b> {{probeData.humidity_warning_low}} </b> </td>
									</tr>
									<tr v-if="probeData.probe_type=='Humidity Probe'"> 
										<td> Humidity High Alert </td>
										<td> <b> {{probeData.humidity_alert_high}} </b> </td>
									</tr>
									<tr v-if="probeData.probe_type=='Humidity Probe'"> 
										<td> Humidity Low Alert </td>
										<td> <b> {{probeData.humidity_alert_low}} </b> </td>
									</tr>
									<tr> 
										<td> Next Calibration Date </td>
										<td> <b> {{probeData.next_calibration_date}} </b> </td>
									</tr>
									<tr> 
										<td> Frequency To Check Temperatures </td>
										<td> <b> {{probeData.frequency_to_check_temperatures_value}} {{probeData.frequency_to_check_temperatures_unit}} </b> </td>
									</tr>
									<tr> 
										<td> Alarm Time </td>
										<td> <b> {{probeData.alarm_time_value}} {{probeData.alarm_time_unit}} </b> </td>
									</tr>
									<tr> 
										<td> Default Sensor </td>
										<td> <b> {{probeData.default_sensor}} </b> </td>
									</tr>
									<tr> 
										<td> Status </td>
										<td> <b> {{probeData.status}} </b> </td>
									</tr>
									<tr> 
										<td> Configured </td>
										<td> <b> {{probeData.is_configured}} </b> </td>
									</tr>
									<tr> 
										<td> Monitored </td>
										<td> <b> {{probeData.is_monitored}} </b> </td>
									</tr>
									<tr v-if="probeData.is_monitored=='Yes'"> 
										<td> Online Monitoring Date </td>
										<td> <b> {{probeData.online_monitoring_date}} </b> </td>
									</tr>
									<tr> 
										<td> Location </td>
										<td> <b> {{probeData.location.name}} </b> </td>
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
			probeData: {},
		};
	},
	mounted() {
		this.getProbe();
	},
	methods: {
		getProbe() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/probes/' + id)
			.then(function(resp) {
				app.probeData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching probe data");
			});
		}
	}
};
</script>