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
                <div class="col-sm-3 form-group">
                  <label class="control-label">Probe</label>
                  <select class="form-control" v-model.trim="filterData.probe" ref="probe" required>
                    <option v-for="probe in probes" :value="probe.id">{{probe.serial_number}}</option>
                  </select>
                </div>
                <div class="col-sm-3 form-group">
                  <label class="control-label">Reading</label>
                  <select class="form-control" v-model="filterData.reading" ref="reading" required>
                    <option value="Actual Temperature">Actual Temperature</option>
                    <option value="High Temperature">High Temperature</option>
                    <option value="Low Temperature">Low Temperature</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 form-group">
                  <label class="control-label">Start Date</label>
                  <datepicker
                    v-model="filterData.start_date"
                    :format="formatDate"
                    input-class="form-control"
                    ref="start_date"
                  />
                </div>
                <div class="col-sm-3 form-group">
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
          <div v-if="showGraph==true" class="card-body" id="chart">
            <div id="chart-timeline">
              <apexchart type="line" height="400" :options="chartOptions" :series="series"></apexchart>
            </div>
          </div>
          <div class="card-body">
            <div v-if="showGraph==true" class="details">
              <div class="row">
                <div class="col-sm-2 form-group">
                  <label class="h7">
                    Max(Sensor 1):
                    <b>{{this.filterData.max}}</b>
                  </label>
                </div>
                <div class="col-sm-2 form-group">
                  <label class="h7">
                    Min(Sensor 1):
                    <b>{{this.filterData.min}}</b>
                  </label>
                </div>
                <div class="col-sm-3 form-group">
                  <label class="h7">
                    Default Sensor:
                    <b>{{this.filterData.default_sensor}}</b>
                  </label>
                </div>
              </div>
            </div>
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
        organization: localStorage.getItem("user.organization_id"),
        location: "",
        probe: "",
        start_date: Date(),
        end_date: Date(),
        reading: "Actual Temperature",
        max: 0,
        min: 0,
        default_sensor: ""
      },
      locations: [],
      probes: [],
      probeLogs: {},
      showGraph: false,
      series: [],
      chartOptions: {
        chart: {
          zoom: {
            enabled: false
          }
        },
        title: {
          text: "Temperature Readings",
          align: "left"
        },
        colors: ["#FF0000", "#FFA500", "#FFA500", "#FF0000", "#0000FF"],
        annotations: {
          yaxis: [
            {
              y: 0,
              label: {
                show: true,
                text: "Date"
              }
            }
          ],
          xaxis: [
            {
              x: new Date("01 Nov 2000").getTime(),
              yAxisIndex: 0,
              label: {
                show: true,
                text: "Temperature"
              }
            }
          ]
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: "straight",
          dashArray: [5, 5, 5, 5, 0]
        },
        markers: {
          size: [3, 3, 3]
        },
        xaxis: {
          type: "datetime",
          min: undefined,
          tickAmount: 5
        },
        tooltip: {
          x: {
            format: "dd MMM yyyy"
          }
        }
      },
      selection: "one_month"
    };
  },
  mounted() {
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

    this.populateLocations();
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
            if (resp.data.total > 0) {
              app.showGraph = true;
              app.probeLogs = resp.data;

              //get default sensor
              app.filterData.default_sensor =
                resp.data.data[0].probe.default_sensor;

              //get max temp
              app.filterData.max = Math.max.apply(
                Math,
                app.probeLogs.data.map(function(o) {
                  if (app.filterData.reading == "Actual Temperature") {
                    return o.actual_temperature;
                  } else if (app.filterData.reading == "High Temperature") {
                    return o.temperature_high;
                  } else {
                    return o.temperature_low;
                  }
                })
              );

              //get min temp
              app.filterData.min = Math.min.apply(
                Math,
                app.probeLogs.data.map(function(o) {
                  if (app.filterData.reading == "Actual Temperature") {
                    return o.actual_temperature;
                  } else if (app.filterData.reading == "High Temperature") {
                    return o.temperature_high;
                  } else {
                    return o.temperature_low;
                  }
                })
              );

              //populate actual temp
              let actualTemperatureArray = [];

              app.probeLogs.data.forEach(function(arrayItem) {
                let actual_temperature = arrayItem.actual_temperature;
                let unix_timestamp = arrayItem.unix_timestamp + "000";

                actualTemperatureArray.push([
                  parseInt(unix_timestamp),
                  parseFloat(actual_temperature)
                ]);
              });

              //populate temperature high
              let temperatureHighArray = [];

              app.probeLogs.data.forEach(function(arrayItem) {
                let temperature_high = arrayItem.temperature_high;
                let unix_timestamp = arrayItem.unix_timestamp + "000";

                temperatureHighArray.push([
                  parseInt(unix_timestamp),
                  parseFloat(temperature_high)
                ]);
              });

              //populate temperature low
              let temperatureLowArray = [];

              app.probeLogs.data.forEach(function(arrayItem) {
                let temperature_low = arrayItem.temperature_low;
                let unix_timestamp = arrayItem.unix_timestamp + "000";

                temperatureLowArray.push([
                  parseInt(unix_timestamp),
                  parseFloat(temperature_low)
                ]);
              });

              //populate alerts and warnings

              //alert high
              let alertHighArray = [];

              app.probeLogs.data.forEach(function(arrayItem) {
                let alertHigh = arrayItem.probe.temperature_alert_high;
                let unix_timestamp = arrayItem.unix_timestamp + "000";

                alertHighArray.push([
                  parseInt(unix_timestamp),
                  parseFloat(alertHigh)
                ]);
              });

              //warning high
              let warningHighArray = [];

              app.probeLogs.data.forEach(function(arrayItem) {
                let warningHigh = arrayItem.probe.temperature_warning_high;
                let unix_timestamp = arrayItem.unix_timestamp + "000";

                warningHighArray.push([
                  parseInt(unix_timestamp),
                  parseFloat(warningHigh)
                ]);
              });

              //warning low
              let warningLowArray = [];

              app.probeLogs.data.forEach(function(arrayItem) {
                let warningLow = arrayItem.probe.temperature_warning_low;
                let unix_timestamp = arrayItem.unix_timestamp + "000";

                warningLowArray.push([
                  parseInt(unix_timestamp),
                  parseFloat(warningLow)
                ]);
              });

              //alert low
              let alertLowArray = [];

              app.probeLogs.data.forEach(function(arrayItem) {
                let alertLow = arrayItem.probe.temperature_alert_low;
                let unix_timestamp = arrayItem.unix_timestamp + "000";

                alertLowArray.push([
                  parseInt(unix_timestamp),
                  parseFloat(alertLow)
                ]);
              });

              app.series = [
                {
                  name: "Alert High",
                  data: alertHighArray
                },
                {
                  name: "Warning High",
                  data: warningHighArray
                },
                {
                  name: "Warning Low",
                  data: warningLowArray
                },
                {
                  name: "Alert Low",
                  data: alertLowArray
                }
              ];

              if (app.filterData.reading == "Actual Temperature") {
                app.series.push({
                  name: "Actual Temperature",
                  data: actualTemperatureArray
                });
              } else if (app.filterData.reading == "High Temperature") {
                app.series.push({
                  name: "High Temperature",
                  data: temperatureHighArray
                });
              } else {
                app.series.push({
                  name: "Low Temperature",
                  data: temperatureLowArray
                });
              }
            } else {
              app.probeLogs = {};
              app.showGraph = false;
            }
          })
          .catch(function() {
            console.log("Error fetching probe logs");
          });
      }
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