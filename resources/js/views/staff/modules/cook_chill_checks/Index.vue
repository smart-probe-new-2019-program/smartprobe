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
                <h5>View All Cook Chill Checks</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/staff/cook_chill_checks/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add Cook Chill Check
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
                      @selected="getCookChillChecks()"
                      :format="formatDate"
                      input-class="form-control"
                      ref="start_date"
                    />
                  </div>
                  <div class="col-sm-2 form-group">
                    <label class="control-label">End Date</label>
                    <datepicker
                      v-model="filters.end_date"
                      @selected="getCookChillChecks()"
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
                :data="cookChillChecks.data"
                :show-filter="false"
                filter-placeholder="Search cook chill checks.."
                filter-no-results="No entries found!"
                table-class="table"
                ref="table"
              >
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="user.full_name"
                  label="User"
                />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="supplier.name"
                  label="Supplier"
                />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="type_of_food.name"
                  label="Type of Food"
                />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="probe.name"
                  label="Probe"
                />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/staff/cook_chill_checks/view/${row.id}`">
                      <i class="icon-fa icon-fa-eye" />
                    </a>
                    <a :href="`/staff/cook_chill_checks/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteCookChillCheck(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="cookChillChecks"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getCookChillChecks"
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
      cookChillChecks: {},
      filters: {
        organization: localStorage.getItem("user.organization_id"),
        user_id: localStorage.getItem("user.id"),
        start_date: Date(),
        end_date: Date()
      }
    };
  },
  mounted() {
    this.getCookChillChecks();
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
    getCookChillChecks: lodash.debounce(function(page = 1) {
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
            `/api/admin/cook_chill_checks/get?page=${page}&organization_id=${app.filters.organization}&user_id=${app.filters.user_id}&start_date=${app.filters.start_date}&end_date=${app.filters.end_date}`
          )
          .then(function(resp) {
            app.cookChillChecks = resp.data;
          })
          .catch(function() {
            console.log("Error fetching filtered cook chill checks");
          });
      }
    }, 500),
    deleteCookChillCheck(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this entry?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/cook_chill_checks/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the entry. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Entry deleted!", "Success!");
                app.$refs.table.refresh();
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