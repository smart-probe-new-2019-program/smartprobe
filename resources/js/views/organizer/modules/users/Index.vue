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
						<router-link to="/organizer/users/add" class="btn btn-success btn-xs float-right"><i class="icon-fa icon-fa-plus-circle"/>Add User</router-link>
					</div>
			  	</div>  
          </div>
          <div class="card-body">
				<table-component :data="fetchData" :show-filter="false" filter-placeholder="Search users.." filter-no-results="No users found!" table-class="table" ref="table">
					<table-column :sortable="false" :filterable="false" show="first_name" label="Firstname"/>
					<table-column :sortable="false" show="last_name" label="Lastname"/>
					<table-column :sortable="false" show="email" label="Email"/>
					<table-column :sortable="false" show="username" label="Username"/>
					<table-column :sortable="false" show="role" label="Role"/>
					<table-column :sortable="false" :filterable="false" label="Actions">
						<template slot-scope="row">
							<a :href="`/organizer/users/view/${row.id}`"><i class="icon-fa icon-fa-eye"/></a>
							<a :href="`/organizer/users/edit/${row.id}`"><i class="icon-fa icon-fa-pencil-square-o"/></a>
							<a v-on:click="deleteUser(`${row.id}`)"><i class="icon-fa icon-fa-trash"/></a>
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
      const response = await axios.get(`/api/admin/users/get?page=${page}&organization_id=${this.organization_id}`)

      return {
        data: response.data.data,
        pagination: {
          totalPages: response.data.last_page,
          currentPage: page,
          count: response.data.count
        }
	  }
	},
	deleteUser(id){
		let app = this;
		notie.confirm({
			text: "Are you sure you want to delete this User?",
			cancelCallback: function () {
				// notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
			},
			submitCallback: function () {
				axios.delete('/api/admin/users/' + id)
				.then((resp) => {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while deleting the user. Please contact admin about this.', 'Error!');
					}
					else{
						toastr['success']('User deleted!', 'Success!');
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