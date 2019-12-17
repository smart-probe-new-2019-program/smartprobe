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
			  	</div>  
          </div>
          <div class="card-body">
				<table-component :data="fetchData" :show-filter="false" filter-placeholder="Search files.." filter-no-results="No files found!" table-class="table" ref="table">
					<table-column :sortable="false" :filterable="false" show="filename" label="Filename"/>
					<table-column :sortable="false" :filterable="false" show="created_at" label="Created At"/>
					<table-column :sortable="false" :filterable="false" label="Actions">
						<template slot-scope="row">
							<a v-on:click="downloadFile(`${row.path}`,`${row.filename}`)"><i class="icon-fa icon-fa-download"/></a>
						</template>
					</table-column>
				</table-component>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import { TableComponent, TableColumn } from 'vue-table-component'

export default {
  components: {
    TableComponent,
    TableColumn
  },
  data() {
		return {
			organization_id: localStorage.getItem("user.organization_id"),
		};
	},
  methods: {
	mounted() {
		toastr.options = {
			closeButton: true,
			debug: false,
			positionClass: 'toast-top-right',
			onclick: null,
			showDuration: '1000',
			hideDuration: '1000',
			timeOut: '5000',
			extendedTimeOut: '1000',
			showEasing: 'swing',
			hideEasing: 'linear',
			showMethod: 'fadeIn',
			hideMethod: 'fadeOut'
		}
	},
    async fetchData ({ page, filter, sort }) {
      const response = await axios.get(`/api/admin/file_entries/get?page=${page}&organization_id=${this.organization_id}`)

      return {
        data: response.data.data,
        pagination: {
          totalPages: response.data.last_page,
          currentPage: page,
          count: response.data.count
        }
	  }
	},
	downloadFile(path, filename) {
		axios.get('/api/admin/file_entries/' + path + '/' + filename)
		.then((response) => {
			let fileURL = window.URL.createObjectURL(new Blob([response.data]));
			let fileLink = document.createElement('a');

			fileLink.href = fileURL;
			fileLink.setAttribute('download', filename);
			document.body.appendChild(fileLink);

			fileLink.click();
		});
	}
  }
}
</script>