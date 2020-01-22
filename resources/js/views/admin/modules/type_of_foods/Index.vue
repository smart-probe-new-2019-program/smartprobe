<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Type of Foods</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Types of Food</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/admin/type_of_foods/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add Food Type
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
                      @input="getTypeOfFoods()"
                      v-model="filters.keyword"
                      class="form-control"
                      placeholder="Type name here.."
                    />
                  </div>
                  <div class="col-sm-3 form-group">
                    <label class="control-label">Filter by Organization:</label>
                    <select
                      class="form-control"
                      @change="getTypeOfFoods()"
                      v-model.trim="filters.organization"
                      ref="organization"
                    >
                      <option value="All" selected>All</option>
                      <option
                        v-for="organization in organizations"
                        :value="organization.id"
                      >{{ organization.name }}</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="typeOfFoods.data"
                :show-filter="false"
                filter-placeholder="Search food type.."
                filter-no-results="No food types found!"
                table-class="table"
                ref="table"
              >
                <table-column :sortable="false" :filterable="false" show="name" label="Name" />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="organization.name"
                  label="Organization"
                />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/admin/type_of_foods/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteTypeOfFood(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="typeOfFoods"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getTypeOfFoods"
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
      typeOfFoods: {},
      organizations: [],
      filters: {
        keyword: null,
        organization: "All"
      }
    };
  },
  mounted() {
    this.getOrganizations();
    this.getTypeOfFoods();
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
    getTypeOfFoods: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/type_of_foods/get?page=${page}&organization_id=${app.filters.organization}&filter_keyword=${app.filters.keyword}`
        )
        .then(function(resp) {
          app.typeOfFoods = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered type of foods");
        });
    }, 500),
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
    deleteTypeOfFood(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this Food Type?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/type_of_foods/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the food type. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Type of Food deleted!", "Success!");
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