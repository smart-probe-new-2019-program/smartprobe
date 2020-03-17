<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Manage Checklists</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Managed Checklists</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/admin/manage_checklists/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add Checklist
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3 form-group">
                <label class="control-label">Filter by Organization:</label>
                <select
                  class="form-control"
                  @change="getChecklists()"
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
              <div class="col-sm-3 form-group">
                <label class="control-label">Checklist Type</label>
                <select
                  class="form-control"
                  @change="getChecklists()"
                  v-model="filters.type"
                  ref="type"
                  required
                >
                  <option value="All">All</option>
                  <option value="Staff Daily Checklists">Staff Daily Checklists</option>
                  <option value="Cleaning - Hygiene">Cleaning - Hygiene</option>
                  <option value="Pest Control - Daily - Quarterly">Pest Control - Daily - Quarterly</option>
                  <option value="Equipment">Equipment</option>
                  <option value="Misc Procedures">Misc Procedures</option>
                  <option value="Staff Manuals and Procedures">Staff Manuals and Procedures</option>
                  <option value="Matrix Checklists">Matrix Checklists</option>
                </select>
              </div>
              <div class="col-sm-4 form-group">
                <label class="control-label">Search:</label>
                <input
                  type="text"
                  @input="getChecklists()"
                  v-model="filters.keyword"
                  class="form-control"
                  placeholder="Search for an item/time/area/category here.."
                />
              </div>
            </div>
            <div>
              <table-component
                :data="checklists.data"
                :show-filter="false"
                filter-placeholder="Search checklists.."
                filter-no-results="No checklists found!"
                table-class="table"
                ref="table"
              >
                <table-column :sortable="false" :filterable="false" show="type" label="Type" />
                <table-column :sortable="false" :filterable="false" show="time.name" label="Time" />
                <table-column :sortable="false" :filterable="false" show="area.name" label="Area" />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="category.name"
                  label="Category"
                />
                <table-column :sortable="false" :filterable="false" show="item.name" label="Item" />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/admin/manage_checklists/view/${row.id}`">
                      <i class="icon-fa icon-fa-eye" />
                    </a>
                    <a :href="`/admin/manage_checklists/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteManageChecklist(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="checklists"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getChecklists"
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
      checklists: {},
      organizations: [],
      filters: {
        keyword: null,
        organization: "All",
        type: "All"
      }
    };
  },
  mounted() {
    this.getOrganizations();
    this.getChecklists();
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
    getChecklists: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/manage_checklists/getManageChecklistsForAdmin?page=${page}&organization_id=${app.filters.organization}&filter_type=${app.filters.type}&filter_keyword=${app.filters.keyword}`
        )
        .then(function(resp) {
          app.checklists = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered checklists");
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
    deleteManageChecklist(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this Checklist?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/manage_checklists/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the checklist. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Checklist deleted!", "Success!");
                app.getChecklists();
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