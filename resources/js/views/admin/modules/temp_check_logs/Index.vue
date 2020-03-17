<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Temperature Check Logs</h3>
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
                  <label class="control-label">Organization</label>
                  <select
                    class="form-control"
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
                  <button @click="getTempCheckLogs()" class="btn btn-sm btn-primary">
                    <i class="icon-fa icon-fa-eye" /> Show
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <table-component
              :data="tempCheckLogs.data"
              :show-filter="false"
              filter-placeholder="Search logs.."
              filter-no-results="No logs found!"
              table-class="table"
              ref="table"
            >
              <table-column
                :sortable="false"
                :filterable="false"
                show="probe.serial_number"
                label="Serial #"
              />
              <table-column :sortable="false" :filterable="false" show="probe.name" label="Name" />
              <table-column
                :sortable="false"
                :filterable="false"
                show="created_at"
                label="Date/Time"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="corrective_action.user.full_name"
                label="User"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="current_temperature"
                label="Current Temperature"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="max_temperature"
                label="Max Temperature"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                show="min_temperature"
                label="Min Temperature"
              />
              <table-column :sortable="false" :filterable="false" show="comment" label="Comment" />
            </table-component>
            <br />
            <pagination
              :data="tempCheckLogs"
              :limit="-1"
              :show-disabled="true"
              size="default"
              align="right"
              @pagination-change-page="getTempCheckLogs"
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
        start_date: Date(),
        end_date: Date()
      },
      organizations: [],
      tempCheckLogs: {}
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
    getTempCheckLogs() {
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
            `/api/admin/corrective_actions/getTempCheckLogs?start_date=${app.filterData.start_date}&end_date=${app.filterData.end_date}`
          )
          .then(function(resp) {
            app.tempCheckLogs = resp.data;
          })
          .catch(function() {
            console.log("Error fetching temperature check logs");
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
    }
  }
};
</script>