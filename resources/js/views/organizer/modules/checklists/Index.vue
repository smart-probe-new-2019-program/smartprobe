<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Checklist Entries</h3>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Checklist Areas</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/organizer/checklist_areas/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add Area
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 form-group">
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="control-label">Search:</label>
                    <input
                      type="text"
                      @input="getChecklistAreas()"
                      v-model="filters.checklist_area.keyword"
                      class="form-control"
                      placeholder="Type keywords here.."
                    />
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="checklistAreas.data"
                :show-filter="false"
                filter-placeholder="Search areas.."
                filter-no-results="No areas found!"
                table-class="table"
                ref="checklistAreaTable"
              >
                <table-column :sortable="false" :filterable="false" show="name" label="Name" />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/organizer/checklist_areas/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteChecklistArea(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="checklistAreas"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getChecklistAreas"
              ></pagination>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Checklist Times</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/organizer/checklist_times/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add Time
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 form-group">
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="control-label">Search:</label>
                    <input
                      type="text"
                      @input="getChecklistTimes()"
                      v-model="filters.checklist_time.keyword"
                      class="form-control"
                      placeholder="Type keywords here.."
                    />
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="checklistTimes.data"
                :show-filter="false"
                filter-placeholder="Search times.."
                filter-no-results="No times found!"
                table-class="table"
                ref="checklistTimeTable"
              >
                <table-column :sortable="false" :filterable="false" show="name" label="Name" />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/organizer/checklist_times/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteChecklistTime(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="checklistTimes"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getChecklistTimes"
              ></pagination>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Checklist Categories</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/organizer/checklist_categories/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add Category
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 form-group">
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="control-label">Search:</label>
                    <input
                      type="text"
                      @input="getChecklistCategories()"
                      v-model="filters.checklist_category.keyword"
                      class="form-control"
                      placeholder="Type keywords here.."
                    />
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="checklistCategories.data"
                :show-filter="false"
                filter-placeholder="Search categories.."
                filter-no-results="No categories found!"
                table-class="table"
                ref="checklistCategoryTable"
              >
                <table-column :sortable="false" :filterable="false" show="name" label="Name" />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/organizer/checklist_categories/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteChecklistCategory(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="checklistCategories"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getChecklistCategories"
              ></pagination>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Checklist Items</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/organizer/checklist_items/add"
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
                  <div class="col-sm-6 form-group">
                    <label class="control-label">Search:</label>
                    <input
                      type="text"
                      @input="getChecklistItems()"
                      v-model="filters.checklist_item.keyword"
                      class="form-control"
                      placeholder="Type keywords here.."
                    />
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="checklistItems.data"
                :show-filter="false"
                filter-placeholder="Search items.."
                filter-no-results="No items found!"
                table-class="table"
                ref="checklistItemTable"
              >
                <table-column :sortable="false" :filterable="false" show="name" label="Name" />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/organizer/checklist_items/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteChecklistItem(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="checklistItems"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getChecklistItems"
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
      checklistAreas: {},
      checklistTimes: {},
      checklistCategories: {},
      checklistItems: {},
      organizations: [],
      filters: {
        checklist_area: {
          keyword: null,
          organization: localStorage.getItem("user.organization_id")
        },
        checklist_time: {
          keyword: null,
          organization: localStorage.getItem("user.organization_id")
        },
        checklist_category: {
          keyword: null,
          organization: localStorage.getItem("user.organization_id")
        },
        checklist_item: {
          keyword: null,
          organization: localStorage.getItem("user.organization_id")
        }
      }
    };
  },
  mounted() {
    this.getChecklistAreas();
    this.getChecklistTimes();
    this.getChecklistCategories();
    this.getChecklistItems();
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
    getChecklistAreas: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/checklist_areas/get?page=${page}&organization_id=${app.filters.checklist_area.organization}&filter_keyword=${app.filters.checklist_area.keyword}`
        )
        .then(function(resp) {
          app.checklistAreas = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered checklist areas");
        });
    }, 500),
    getChecklistTimes: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/checklist_times/get?page=${page}&organization_id=${app.filters.checklist_time.organization}&filter_keyword=${app.filters.checklist_time.keyword}`
        )
        .then(function(resp) {
          app.checklistTimes = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered checklist times");
        });
    }, 500),
    getChecklistCategories: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/checklist_categories/get?page=${page}&organization_id=${app.filters.checklist_category.organization}&filter_keyword=${app.filters.checklist_category.keyword}`
        )
        .then(function(resp) {
          app.checklistCategories = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered checklist categories");
        });
    }, 500),
    getChecklistItems: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/checklist_items/get?page=${page}&organization_id=${app.filters.checklist_item.organization}&filter_keyword=${app.filters.checklist_item.keyword}`
        )
        .then(function(resp) {
          app.checklistItems = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered checklist items");
        });
    }, 500),
    deleteChecklistArea(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this checklist area?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/checklist_areas/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the area. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Checklist Area deleted!", "Success!");
                app.$refs.checklistAreaTable.refresh();
              }
            })
            .catch(error => {
              console.log("Error on ajax call!");
            });
        }
      });
    },
    deleteChecklistTime(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this checklist time?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/checklist_times/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the time. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Checklist Time deleted!", "Success!");
                app.$refs.checklistTimeTable.refresh();
              }
            })
            .catch(error => {
              console.log("Error on ajax call!");
            });
        }
      });
    },
    deleteChecklistCategory(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this checklist category?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/checklist_categories/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the category. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Checklist Category deleted!", "Success!");
                app.$refs.checklistCategoryTable.refresh();
              }
            })
            .catch(error => {
              console.log("Error on ajax call!");
            });
        }
      });
    },
    deleteChecklistItem(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this checklist item?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/checklist_items/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the item. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Checklist Item deleted!", "Success!");
                app.$refs.checklistItemTable.refresh();
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