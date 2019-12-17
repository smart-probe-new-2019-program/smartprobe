<template>
	<div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Cook Chill Checks</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
			  	<div class="row">
					<div class="col-sm-6">
						<h5>View All Cook Chill Checks</h5>
					</div>
					<div class="col-sm-6">
						<router-link to="/admin/cook_chill_checks/add" class="btn btn-success btn-xs float-right"><i class="icon-fa icon-fa-plus-circle"/>Add Cook Chill Check</router-link>
					</div>
			  	</div>  
          </div>
          <div class="card-body">
				<table-component :data="fetchData" :show-filter="false" filter-placeholder="Search cook chill checks.." filter-no-results="No entries found!" table-class="table" ref="table">
					<table-column :sortable="false" :filterable="false" show="organization.name" label="Organization"/>
					<table-column :sortable="false" :filterable="false" show="user.full_name" label="User"/>
					<table-column :sortable="false" :filterable="false" show="supplier.name" label="Supplier"/>
					<table-column :sortable="false" :filterable="false" show="type_of_food.name" label="Type of Food"/>
					<table-column :sortable="false" :filterable="false" show="probe.name" label="Probe"/>
					<table-column :sortable="false" :filterable="false" label="Actions">
						<template slot-scope="row">
							<a :href="`/admin/cook_chill_checks/view/${row.id}`"><i class="icon-fa icon-fa-eye"/></a>
							<a :href="`/admin/cook_chill_checks/edit/${row.id}`"><i class="icon-fa icon-fa-pencil-square-o"/></a>
							<a v-on:click="deleteCookChillCheck(`${row.id}`)"><i class="icon-fa icon-fa-trash"/></a>
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
      const response = await axios.get(`/api/admin/cook_chill_checks/get?page=${page}`)

      return {
        data: response.data.data,
        pagination: {
          totalPages: response.data.last_page,
          currentPage: page,
          count: response.data.count
        }
	  }
	},
	deleteCookChillCheck(id){
		let app = this;
		notie.confirm({
			text: "Are you sure you want to delete this entry?",
			cancelCallback: function () {
				// notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
			},
			submitCallback: function () {
				axios.delete('/api/admin/cook_chill_checks/' + id)
				.then((resp) => {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while deleting the entry. Please contact admin about this.', 'Error!');
					}
					else{
						toastr['success']('Entry deleted!', 'Success!');
						app.$refs.table.refresh();
					}
				})
				.catch((error) => {
					console.log("Error on ajax call!");
				});
			}
		});		
	}
  }
}
</script>