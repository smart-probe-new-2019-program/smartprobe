<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Dashboard</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View Latest Logs</h5>
              </div>
            </div>
          </div>
          <div class="card-body d-flex flex-column">
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-3 form-group">
                  <label class="control-label">Organization</label>
                  <select
                    class="form-control"
                    @change="getLatestLogs()"
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
              </div>
            </div>
          </div>
          <div class="card-body">
            <table-component
              :data="latestLogs.data"
              :show-filter="false"
              filter-placeholder="Search logs.."
              filter-no-results="No logs found!"
              table-class="table"
              ref="table"
            >
              <table-column
                :sortable="false"
                :filterable="false"
                show="latest_log.created_at"
                label="Date/Time"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="latest_log.temperature_high"
                label="Sensor 1 Current"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="latest_log.temperature_low"
                label="Sensor 2 Current"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="min_temperature_high"
                label="Daily Min(Sensor 1)"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="max_temperature_high"
                label="Daily Max(Sensor 1)"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="min_temperature_low"
                label="Daily Min(Sensor 2)"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="max_temperature_low"
                label="Daily Max(Sensor 2)"
              />
              <table-column :sortable="false" :filterable="false" show="probe_name" label="Probe" />
              <table-column
                :sortable="false"
                :filterable="false"
                show="latest_log.voltage"
                label="Voltage"
              />
            </table-component>
            <br />
            <pagination
              :data="latestLogs"
              :limit="-1"
              :show-disabled="true"
              size="default"
              align="right"
              @pagination-change-page="getLatestLogs"
            ></pagination>
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
      filterData: {
        organization: null
      },
      organizations: [],
      latestLogs: {}
    };
  },
  mounted() {
    this.getOrganizations();
    // this.getLatestLogs();
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
    getLatestLogs() {
      let app = this;
      axios
        .get(
          `/api/admin/probes_logs/getLatestLogs/` + app.filterData.organization
        )
        .then(function(resp) {
          app.latestLogs = resp.data;
        })
        .catch(function() {
          console.log("Error fetching latest logs");
        });
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