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
                <h5>View All Probes</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/probes/add" class="btn btn-success btn-xs float-right">
                  <i class="icon-fa icon-fa-plus-circle" />Add Probe
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 form-group">
                <div class="row">
                  <div class="col-sm-4 form-group">
                    <label class="control-label">Search:</label>
                    <input
                      type="text"
                      @input="getProbes()"
                      v-model="filters.keyword"
                      class="form-control"
                      placeholder="Search for name or serial here.."
                    />
                  </div>
                  <div class="col-sm-3 form-group">
                    <label class="control-label">Filter by Status:</label>
                    <select @change="getProbes()" v-model="filters.status" class="form-control">
                      <option value="All" selected>All</option>
                      <option value="New">New</option>
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                      <option value="Deleted">Deleted</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="probes.data"
                :show-filter="false"
                filter-placeholder="Search probes.."
                filter-no-results="No probes found!"
                table-class="table"
                ref="table"
              >
                <table-column :sortable="false" :filterable="false" show="name" label="Name" />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="serial_number"
                  label="Serial Number"
                />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="location.name"
                  label="Location"
                />
                <table-column :sortable="false" :filterable="false" show="probe_type" label="Type" />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="next_calibration_date"
                  label="Next Calibration Date"
                />
                <table-column :sortable="false" :filterable="false" show="status" label="Status" />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/organizer/probes/view/${row.id}`">
                      <i class="icon-fa icon-fa-eye" />
                    </a>
                    <a :href="`/organizer/probes/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteProbe(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="probes"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getProbes"
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

export default {
  components: {
    lodash
  },
  data() {
    return {
      probes: {},
      filters: {
        keyword: null,
        organization: localStorage.getItem("user.organization_id"),
        status: "All"
      }
    };
  },
  mounted() {
    this.getProbes();
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
    getProbes: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/probes/get?page=${page}&organization_id=${app.filters.organization}&filter_keyword=${app.filters.keyword}&filter_status=${app.filters.status}`
        )
        .then(function(resp) {
          app.probes = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered probes");
        });
    }, 500),
    deleteProbe(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this Probe?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/probes/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the probe. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Probe deleted!", "Success!");
                app.getProbes();
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