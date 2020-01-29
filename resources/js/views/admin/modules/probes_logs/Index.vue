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
                <div class="col-sm-2 form-group">
                  <label class="control-label">Organization</label>
                  <select
                    class="form-control"
                    @change="populateLocations()"
                    v-model.trim="filterData.organization"
                    ref="organization"
                    required
                  >
                    <option
                      v-for="organization in organizations"
                      :value="organization.id"
                    >{{organization.name}}</option>
                  </select>
                </div>
                <div class="col-sm-2 form-group">
                  <label class="control-label">Location</label>
                  <select
                    class="form-control"
                    @change="populateProbes()"
                    v-model.trim="filterData.location"
                    ref="location"
                    required
                  >
                    <option v-for="location in locations" :value="location.id">{{location.name}}</option>
                  </select>
                </div>
                <div class="col-sm-2 form-group">
                  <label class="control-label">Probe</label>
                  <select class="form-control" v-model.trim="filterData.probe" ref="probe" required>
                    <option v-for="probe in probes" :value="probe.id">{{probe.serial_number}}</option>
                  </select>
                </div>
                <div class="col-sm-2 form-group">
                  <label class="control-label">Start Date</label>
                  <datepicker
                    v-model="filterData.start_date"
                    :format="formatDate"
                    input-class="form-control"
                    ref="start_date"
                  />
                </div>
                <div class="col-sm-2 form-group">
                  <label class="control-label">End Date</label>
                  <datepicker
                    v-model="filterData.end_date"
                    :format="formatDate"
                    input-class="form-control"
                    ref="end_date"
                  />
                </div>
                <div class="col-sm-2 form-group mt-auto">
                  <button @click="getProbeLogs()" class="btn btn-sm btn-primary">
                    <i class="icon-fa icon-fa-eye" /> Show
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <table-component
              :data="probeLogs.data"
              :show-filter="false"
              filter-placeholder="Search logs.."
              filter-no-results="No logs found!"
              table-class="table"
              ref="table"
            >
              <table-column
                :sortable="false"
                :filterable="false"
                show="created_at"
                label="Date/Time"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="temperature_high"
                label="Sensor 1"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="status_1"
                label="Status/Warning"
              />
              <table-column :sortable="false" :filterable="false" show="trip_1" label="Trip/Alarm" />
              <table-column
                :sortable="false"
                :filterable="false"
                show="temperature_low"
                label="Sensor 2"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="status_2"
                label="Status/Warning"
              />
              <table-column :sortable="false" :filterable="false" show="trip_2" label="Trip/Alarm" />
              <!-- <table-column :sortable="false" :filterable="false" label="Actions">
						<template slot-scope="row">
							<a :href="`/admin/locations/view/${row.id}`"><i class="icon-fa icon-fa-eye"/></a>
							<a :href="`/admin/locations/edit/${row.id}`"><i class="icon-fa icon-fa-pencil-square-o"/></a>
							<a v-on:click="deleteLocation(`${row.id}`)"><i class="icon-fa icon-fa-trash"/></a>
						</template>
              </table-column>-->
            </table-component>
            <br />
            <pagination
              :data="probeLogs"
              :limit="-1"
              :show-disabled="true"
              size="default"
              align="right"
              @pagination-change-page="getProbeLogs"
            ></pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import lodash from "lodash";
import Datepicker from "vuejs-datepicker";
import moment from "moment";

export default {
  components: {
    lodash,
    Datepicker,
    moment
  },
  data() {
    return {
      filterData: {
        organization: "",
        location: "",
        probe: "",
        start_date: Date(),
        end_date: Date()
      },
      organizations: [],
      locations: [],
      probes: [],
      probeLogs: {}
    };
  },
  mounted() {
    this.getOrganizations();
    toastr.options = {
      closeButton: true,
      debug: false,
      positionClass: "toast-top-right",
      onclick: null,
      showDuration: "1000",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut"
    };
  },
  methods: {
    formatDate(date) {
      return moment(date).format("MMM DD, YYYY");
    },
    getProbeLogs() {
      let app = this;

      //Convert real value of dates to YYYY-MM-DD format before passing to ajax
      app.filterData.start_date = moment(app.filterData.start_date).format(
        "YYYY-MM-DD"
      );
      app.filterData.end_date = moment(app.filterData.end_date).format(
        "YYYY-MM-DD"
      );

      if (app.filterData.start_date > app.filterData.end_date) {
        toastr["error"](
          "Start date cannot be greater than end date!",
          "Error!"
        );
      } else {
        axios
          .get(
            `/api/admin/probes_logs/getProbesLogsByProbeID?probe=${app.filterData.probe}&start_date=${app.filterData.start_date}&end_date=${app.filterData.end_date}`
          )
          .then(function(resp) {
            app.probeLogs = resp.data;
          })
          .catch(function() {
            console.log("Error fetching probe logs");
          });
      }
    },
    getOrganizations() {
      let app = this;
      axios
        .get("/api/admin/organizations/getOrganizationsForDropdown")
        .then(function(resp) {
          app.organizations = resp.data;
        })
        .catch(function() {
          console.log("Error fetching organizations");
        });
    },
    populateLocations() {
      let app = this;
      axios
        .get(
          "/api/admin/locations/getLocationsByOrganizationID/" +
            app.filterData.organization
        )
        .then(function(resp) {
          app.locations = resp.data;
          app.probes = [];
          app.probeLogs = [];
        })
        .catch(function() {
          console.log("Error fetching locations");
        });
    },
    populateProbes() {
      let app = this;
      axios
        .get(
          "/api/admin/probes/getProbesByLocationID/" + app.filterData.location
        )
        .then(function(resp) {
          app.probes = resp.data;
        })
        .catch(function() {
          console.log("Error fetching probes");
        });
    }
  }
};
</script>