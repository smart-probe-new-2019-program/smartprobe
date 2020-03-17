<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Contacts</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Contacts</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/organizer/contacts/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add
                  Contact
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
                      @input="getContacts()"
                      v-model="filters.keyword"
                      class="form-control"
                      placeholder="Type keywords here.."
                    />
                  </div>
                  <div class="col-sm-3 form-group">
                    <label class="control-label">Filter by Location:</label>
                    <select
                      class="form-control"
                      @change="getContacts()"
                      v-model.trim="filters.location"
                      ref="location"
                    >
                      <option value="All" selected>All</option>
                      <option v-for="location in locations" :value="location.id">{{ location.name }}</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="contacts.data"
                :show-filter="false"
                filter-placeholder="Search contacts.."
                filter-no-results="No contacts found!"
                table-class="table"
                ref="table"
              >
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="organization.name"
                  label="Organization"
                />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="location.name"
                  label="Location"
                />
                <table-column :sortable="false" :filterable="false" show="type" label="Type" />
                <table-column :sortable="false" :filterable="false" show="value" label="Value" />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/organizer/contacts/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteContact(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="contacts"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getContacts"
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
      contacts: {},
      locations: [],
      filters: {
        keyword: null,
        organization: localStorage.getItem("user.organization_id"),
        location: "All"
      }
    };
  },
  mounted() {
    this.populateLocations();
    this.getContacts();
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
    getContacts: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/contacts/get?page=${page}&organization_id=${app.filters.organization}&location_id=${app.filters.location}&filter_keyword=${app.filters.keyword}`
        )
        .then(function(resp) {
          app.contacts = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered contacts");
        });
    }, 500),
    populateLocations() {
      let app = this;
      axios
        .get(
          "/api/admin/locations/getLocationsByOrganizationID/" +
            app.filters.organization
        )
        .then(function(resp) {
          app.locations = resp.data;
          app.getContacts();
        })
        .catch(function() {
          console.log("Error fetching locations");
        });
    },
    deleteContact(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this Contact?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/contacts/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the contact. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("Contact deleted!", "Success!");
                app.getContacts();
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
