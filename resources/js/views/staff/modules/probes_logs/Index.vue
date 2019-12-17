<template>
	<div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Probes Logs</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
			  	<div class="row">
					<div class="col-sm-6">
						<h5>View All Logs</h5>
					</div>
			  	</div>  
          </div>
		  <div class="card-body d-flex flex-column">
			  <div class="panel-body">
			  	<div class="row">
					<div class="col-sm-3 form-group">
						<label class="control-label">Probe</label>
						<select class="form-control" v-model.trim="filterData.probe" ref="probe" required>
							<option v-for="probe in probes" :value="probe.id">
								{{probe.serial_number}}
							</option>
						</select>
					</div>
					<div class="col-sm-3 form-group mt-auto">
						<button @click="fetchLogs()" class="btn btn-sm btn-primary"><i class="icon-fa icon-fa-eye"/> Show</button>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-xl-4 mb-4">
						<div class="form-group">
							<label >From</label>
							<datepicker input-class="form-control" @selected="highlightFrom"/>
						</div>
						<div class="form-group">
							<label>To</label>
							<datepicker input-class="form-control" @selected="highlightTo"/>
						</div>
						<div class="form-group">
							<label>Result</label>
							<datepicker :highlighted="highlighted" input-class="form-control"/>
						</div>
					</div>
				</div> -->
			  </div>
          </div>
          <div class="card-body">
				<table-component :data="probeLogs" :show-filter="false" filter-placeholder="Search logs.." filter-no-results="No logs found!" table-class="table" ref="table">
					<table-column :sortable="false" :filterable="false" show="created_at" label="Date/Time"/>
					<table-column :sortable="false" :filterable="false" show="temperature_low" label="Sensor 1"/>
					<table-column :sortable="false" :filterable="false" show="status_1" label="Status/Warning"/>
					<table-column :sortable="false" :filterable="false" show="trip_1" label="Trip/Alarm"/>
					<table-column :sortable="false" :filterable="false" show="temperature_high" label="Sensor 2"/>
					<table-column :sortable="false" :filterable="false" show="status_2" label="Status/Warning"/>
					<table-column :sortable="false" :filterable="false" show="trip_2" label="Trip/Alarm"/>
					<!-- <table-column :sortable="false" :filterable="false" label="Actions">
						<template slot-scope="row">
							<a :href="`/admin/locations/view/${row.id}`"><i class="icon-fa icon-fa-eye"/></a>
							<a :href="`/admin/locations/edit/${row.id}`"><i class="icon-fa icon-fa-pencil-square-o"/></a>
							<a v-on:click="deleteLocation(`${row.id}`)"><i class="icon-fa icon-fa-trash"/></a>
						</template>
					</table-column> -->
				</table-component>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import { TableComponent, TableColumn } from 'vue-table-component'
import Datepicker from 'vuejs-datepicker'

export default {
  components: {
    TableComponent,
	TableColumn,
	Datepicker,
  },
  data() {
	return {
		filterData: {
			organization: localStorage.getItem("user.organization_id"),
			location: localStorage.getItem("user.location_id"),
			probe: ''
		},
		probes: [],
		probeLogs: [],
	};
  },
  mounted() {
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

		this.populateProbes();
  },
  methods: {
	fetchLogs() {
		let app = this;
		axios.get(`/api/admin/probes_logs/getProbesLogsByProbeID/` + app.filterData.probe)
		.then(function(resp) {
			app.probeLogs = resp.data;
		})
		.catch(function() {
			console.log("Error fetching probe logs");
		});
	},
	populateProbes() {
		let app = this;
		axios.get('/api/admin/probes/getProbesByLocationID/' + app.filterData.location)
		.then(function(resp) {
			app.probes = resp.data;
		})
		.catch(function() {
			console.log("Error fetching probes");
		});
	}
  }
}
</script>