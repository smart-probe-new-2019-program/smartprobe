<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Locations</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Locations</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/organizer/locations/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add Location
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
                      @input="getLocations()"
                      v-model="filters.keyword"
                      class="form-control"
                      placeholder="Type keywords here.."
                    />
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="locations.data"
                :show-filter="false"
                filter-placeholder="Search locations.."
                filter-no-results="No locations found!"
                table-class="table"
                ref="table"
              >
                <table-column :sortable="false" :filterable="false" show="name" label="Name" />
                <!-- <table-column :sortable="false" :filterable="false" show="organization.name" label="Organization"/> -->
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/organizer/locations/view/${row.id}`">
                      <i class="icon-fa icon-fa-eye" />
                    </a>
                    <a :href="`/organizer/locations/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteLocation(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="locations"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getLocations"
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
      locations: {},
      organization_id: localStorage.getItem("user.organization_id"),
      filters: {
        keyword: null
      }
    };
  },
  mounted() {
    this.getLocations();
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
    getLocations: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/locations/get?page=${page}&organization_id=${app.organization_id}&filter_keyword=${app.filters.keyword}`
        )
        .then(function(resp) {
          app.locations = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered locations");
        });
    }, 500),
    deleteLocation(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this Location?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/locations/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the location. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Location deleted!", "Success!");
                app.getLocations();
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
