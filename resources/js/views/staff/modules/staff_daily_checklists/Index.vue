<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Staff Daily Checklists</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Staff Daily Checklists</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/staff/staff_daily_checklists/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add Checklist
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 form-group">
                <div class="row">
                  <div class="col-sm-2 form-group">
                    <label class="control-label">Start Date</label>
                    <datepicker
                      v-model="filters.start_date"
                      @selected="getStaffDailyChecklists()"
                      :format="formatDate"
                      input-class="form-control"
                      ref="start_date"
                    />
                  </div>
                  <div class="col-sm-2 form-group">
                    <label class="control-label">End Date</label>
                    <datepicker
                      v-model="filters.end_date"
                      @selected="getStaffDailyChecklists()"
                      :format="formatDate"
                      input-class="form-control"
                      ref="end_date"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="staffDailyChecklists.data"
                :show-filter="false"
                filter-placeholder="Search checklists.."
                filter-no-results="No checklists found!"
                table-class="table"
                ref="table"
              >
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="user.full_name"
                  label="Created By"
                />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="created_at"
                  label="Created At"
                />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/staff/staff_daily_checklists/view/${row.id}`">
                      <i class="icon-fa icon-fa-eye" />
                    </a>
                    <a v-on:click="deleteStaffDailyChecklist(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="staffDailyChecklists"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getStaffDailyChecklists"
              ></pagination>
            </div>
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
      staffDailyChecklists: {},
      filters: {
        organization: localStorage.getItem("user.organization_id"),
        user_id: localStorage.getItem("user.id"),
        start_date: Date(),
        end_date: Date()
      }
    };
  },
  mounted() {
    this.getStaffDailyChecklists();
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
    getStaffDailyChecklists: lodash.debounce(function(page = 1) {
      let app = this;

      //Convert real value of dates to YYYY-MM-DD format before passing to ajax
      app.filters.start_date = moment(app.filters.start_date).format(
        "YYYY-MM-DD"
      );
      app.filters.end_date = moment(app.filters.end_date).format("YYYY-MM-DD");

      if (app.filters.start_date > app.filters.end_date) {
        toastr["error"](
          "Start date cannot be greater than end date!",
          "Error!"
        );
      } else {
        axios
          .get(
            `/api/admin/staff_daily_checklists/get?page=${page}&organization_id=${app.filters.organization}&user_id=${app.filters.user_id}&start_date=${app.filters.start_date}&end_date=${app.filters.end_date}`
          )
          .then(function(resp) {
            app.staffDailyChecklists = resp.data;
          })
          .catch(function() {
            console.log("Error fetching filtered staff daily checklists");
          });
      }
    }, 500),
    deleteStaffDailyChecklist(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this Checklist?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/staff_daily_checklists/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the checklist. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Checklist deleted!", "Success!");
                app.getStaffDailyChecklists();
              }
            })
            .catch(error => {
              console.log("Error on ajax call!");
            });
        }
      });
    }
  }
};
</script>