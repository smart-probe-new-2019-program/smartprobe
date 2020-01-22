<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Items</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Items</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/admin/incoming_deliveries_items/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add Item
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
                      @input="getItems()"
                      v-model="filters.keyword"
                      class="form-control"
                      placeholder="Type keywords here.."
                    />
                  </div>
                  <div class="col-sm-3 form-group">
                    <label class="control-label">Filter by Organization:</label>
                    <select
                      class="form-control"
                      @change="getItems()"
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
                :data="items.data"
                :show-filter="false"
                filter-placeholder="Search items.."
                filter-no-results="No items found!"
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
                    <a :href="`/admin/incoming_deliveries_items/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteItem(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="items"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getItems"
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
      items: {},
      organizations: [],
      filters: {
        keyword: null,
        organization: "All"
      }
    };
  },
  mounted() {
    this.getOrganizations();
    this.getItems();
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
    getItems: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/incoming_deliveries_items/get?page=${page}&organization_id=${app.filters.organization}&filter_keyword=${app.filters.keyword}`
        )
        .then(function(resp) {
          app.items = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered items");
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
    deleteItem(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this Item?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/incoming_deliveries_items/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the item. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Item deleted!", "Success!");
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