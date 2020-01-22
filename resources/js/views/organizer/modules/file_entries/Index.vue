<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">File Entries</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View All Files</h5>
              </div>
              <div class="col-sm-6">
                <router-link
                  to="/organizer/file_entries/add"
                  class="btn btn-success btn-xs float-right"
                >
                  <i class="icon-fa icon-fa-plus-circle" />Add File/s
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
                      @input="getFileEntries()"
                      v-model="filters.keyword"
                      class="form-control"
                      placeholder="Search for files here.."
                    />
                  </div>
                </div>
              </div>
            </div>
            <div>
              <table-component
                :data="file_entries.data"
                :show-filter="false"
                filter-placeholder="Search files.."
                filter-no-results="No files found!"
                table-class="table"
                ref="table"
              >
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="filename"
                  label="Filename"
                />
                <table-column
                  :sortable="false"
                  :filterable="false"
                  show="created_at"
                  label="Created At"
                />
                <table-column :sortable="false" :filterable="false" label="Actions">
                  <template slot-scope="row">
                    <a v-on:click="downloadFile(`${row.path}`,`${row.filename}`)">
                      <i class="icon-fa icon-fa-download" />
                    </a>
                    <a v-on:click="deleteFileEntry(`${row.id}`)">
                      <i class="icon-fa icon-fa-trash" />
                    </a>
                  </template>
                </table-column>
              </table-component>
              <br />
              <pagination
                :data="file_entries"
                :limit="-1"
                :show-disabled="true"
                size="default"
                align="right"
                @pagination-change-page="getFileEntries"
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
      file_entries: {},
      filters: {
        keyword: null,
        organization: localStorage.getItem("user.organization_id")
      }
    };
  },
  mounted() {
    this.getFileEntries();
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
    getFileEntries: lodash.debounce(function(page = 1) {
      let app = this;
      axios
        .get(
          `/api/admin/file_entries/get?page=${page}&organization_id=${app.filters.organization}&filter_keyword=${app.filters.keyword}`
        )
        .then(function(resp) {
          app.file_entries = resp.data;
        })
        .catch(function() {
          console.log("Error fetching filtered file entries");
        });
    }, 500),
    deleteFileEntry(id) {
      let app = this;
      notie.confirm({
        text: "Are you sure you want to delete this File?",
        cancelCallback: function() {
          // notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
        },
        submitCallback: function() {
          axios
            .delete("/api/admin/file_entries/" + id)
            .then(resp => {
              if (resp.data.status == "error") {
                toastr["error"](
                  "Something went wrong while deleting the file. Please contact admin about this.",
                  "Error!"
                );
              } else {
                toastr["success"]("File deleted!", "Success!");
                app.$refs.table.refresh();
              }
            })
            .catch(error => {
              console.log("Error on ajax call!");
            });
        }
      });
    },
    downloadFile(path, filename) {
      axios
        .get("/api/admin/file_entries/" + path + "/" + filename)
        .then(response => {
          let fileURL = window.URL.createObjectURL(new Blob([response.data]));
          let fileLink = document.createElement("a");

          fileLink.href = fileURL;
          fileLink.setAttribute("download", filename);
          document.body.appendChild(fileLink);

          fileLink.click();
        });
    }
  }
};
</script>