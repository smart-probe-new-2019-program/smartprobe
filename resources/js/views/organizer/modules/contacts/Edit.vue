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
                <h5>Edit a Contact</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/contacts" class="btn btn-dark btn-xs float-right">
                  <i class="icon-fa icon-fa-arrow-left"></i>Back
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form @submit.prevent="saveForm">
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="control-label">Location</label>
                    <select
                      class="form-control"
                      v-model.trim="contactsData.location_id"
                      ref="location_id"
                      required
                    >
                      <option v-for="location in locations" :value="location.id">{{location.name}}</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="control-label">Type</label>
                    <select class="form-control" v-model="contactsData.type" ref="type" required>
                      <option value="Phone Number">Phone Number</option>
                      <option value="Email">Email</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="control-label">Value</label>
                    <input
                      type="text"
                      v-model.trim="contactsData.value"
                      class="form-control"
                      ref="value"
                      required
                    />
                  </div>
                </div>
              </div>

              <div class="col-xs-12 form-group">
                <button class="btn btn-sm btn-success">
                  <i class="icon-fa icon-fa-floppy-o" /> Save
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
export default {
  data() {
    return {
      contactsData: {},
      locations: []
    };
  },
  mounted() {
    this.getContact();
    this.populateLocations();
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
    getContact() {
      let app = this;
      let id = app.$route.params.id;
      axios
        .get("/api/admin/contacts/getContact/" + id)
        .then(function(resp) {
          app.contactsData = resp.data;
          app.populateLocations();
        })
        .catch(function() {
          console.log("Error fetching contact data");
        });
    },
    populateLocations() {
      let app = this;
      axios
        .get(
          "/api/admin/locations/getLocationsByOrganizationID/" +
            app.contactsData.organization_id
        )
        .then(function(resp) {
          app.locations = resp.data;
        })
        .catch(function() {
          console.log("Error fetching locations");
        });
    },
    saveForm() {
      let app = this;

      app.contactsData.updated_by = localStorage.getItem("user.id"); //update user id of the one who edited
      axios
        .patch("/api/admin/contacts/" + app.contactsData.id, app.contactsData)
        .then(function(resp) {
          if (resp.data.status == "error") {
            toastr["error"](
              "Something went wrong while updating the contact. Please contact admin about this.",
              "Error!"
            );
          } else {
            app.$router.push("/organizer/contacts");
            toastr["success"]("Contact details updated!", "Success!");
          }
        })
        .catch(function() {
          console.log("Error on ajax call!");
        });
    }
  }
};
</script>
