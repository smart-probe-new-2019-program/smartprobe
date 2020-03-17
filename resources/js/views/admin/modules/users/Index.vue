<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Users</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Users</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/users/add" class="btn btn-success btn-xs float-right">
                  <i class="icon-fa icon-fa-plus-circle" />Add
                  User
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
                      @input="getUsers()"
                      v-model="filters.keyword"
                      class="form-control"
                      placeholder="Type keywords here.."
                    />
                  </div>
                  <div class="col-sm-3 form-group">
                    <label class="control-label">Filter by Role:</label>
                    <select @change="getUsers()" v-model="filters.role" class="form-control">
                      <option value="All" selected>All</option>
                      <option value="Admin">Admin</option>
                      <option value="Organizer">Organizer</option>
                      <option value="Manager">Manager</option>
                      <option value="Staff">Staff</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="users.data"
                :show-filter="false"
                filter-placeholder="Search users.."
                filter-no-results="No users found!"
                table-class="table"
                ref="table"
              >
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="first_name"
                  label="Firstname"
                />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="last_name"
                  label="Lastname"
                />
                <table-column :sortable="false" :filterable="false" show="email" label="Email" />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="username"
                  label="Username"
                />
                <table-column :sortable="false" :filterable="false" show="role" label="Role" />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="organization.name"
                  label="Organization"
                />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a :href="`/admin/users/view/${row.id}`">
                      <i class="icon-fa icon-fa-eye" />
                    </a>
                    <a :href="`/admin/users/edit/${row.id}`">
                      <i class="icon-fa icon-fa-pencil-square-o" />
                    </a>
                    <a v-on:click="deleteUser(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="users"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getUsers"
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
      users: {},
      filters: {
        keyword: null,
        role: "All"
      }
    };
  },
  mounted() {
    this.getUsers();
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
    getUsers: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/users/get?page=${page}&filter_role=${app.filters.role}&filter_keyword=${app.filters.keyword}`
        )
        .then(function(resp) {
          app.users = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered users");
        });
    }, 500),
    deleteUser(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this User?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/users/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the user. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("User deleted!", "Success!");
                app.getUsers();
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
