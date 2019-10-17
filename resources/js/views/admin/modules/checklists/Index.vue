<template>
	<div class="main-content">
		<div class="page-header">
			<h3 class="page-title">Checklists</h3>
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
								<router-link to="/admin/checklist_areas/add" class="btn btn-success btn-xs float-right"><i class="icon-fa icon-fa-plus-circle"/>Add Area</router-link>
							</div>
						</div>  
					</div>
					<div class="card-body">
						<table-component :data="fetchChecklistsAreaData" :show-filter="false" filter-placeholder="Search areas.." filter-no-results="No areas found!" table-class="table" ref="checklistAreaTable">
							<table-column :sortable="false" :filterable="false" show="name" label="Name"/>
							<table-column :sortable="false" :filterable="false" show="organization.name" label="Organization"/>
							<table-column :sortable="false" :filterable="false" label="Actions">
								<template slot-scope="row">
									<a :href="`/admin/checklist_areas/edit/${row.id}`"><i class="icon-fa icon-fa-pencil-square-o"/></a>
									<a v-on:click="deleteChecklistArea(`${row.id}`)"><i class="icon-fa icon-fa-trash"/></a>
								</template>
							</table-column>
						</table-component>
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
								<router-link to="/admin/checklist_times/add" class="btn btn-success btn-xs float-right"><i class="icon-fa icon-fa-plus-circle"/>Add Time</router-link>
							</div>
						</div>  
					</div>
					<div class="card-body">
						<table-component :data="fetchChecklistsTimeData" :show-filter="false" filter-placeholder="Search times.." filter-no-results="No times found!" table-class="table" ref="checklistTimeTable">
							<table-column :sortable="false" :filterable="false" show="name" label="Name"/>
							<table-column :sortable="false" :filterable="false" show="organization.name" label="Organization"/>
							<table-column :sortable="false" :filterable="false" label="Actions">
								<template slot-scope="row">
									<a :href="`/admin/checklist_times/edit/${row.id}`"><i class="icon-fa icon-fa-pencil-square-o"/></a>
									<a v-on:click="deleteChecklistTime(`${row.id}`)"><i class="icon-fa icon-fa-trash"/></a>
								</template>
							</table-column>
						</table-component>
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
								<router-link to="/admin/checklist_categories/add" class="btn btn-success btn-xs float-right"><i class="icon-fa icon-fa-plus-circle"/>Add Category</router-link>
							</div>
						</div>  
					</div>
					<div class="card-body">
						<table-component :data="fetchChecklistsCategoryData" :show-filter="false" filter-placeholder="Search categories.." filter-no-results="No categories found!" table-class="table" ref="checklistCategoryTable">
							<table-column :sortable="false" :filterable="false" show="name" label="Name"/>
							<table-column :sortable="false" :filterable="false" show="organization.name" label="Organization"/>
							<table-column :sortable="false" :filterable="false" label="Actions">
								<template slot-scope="row">
									<a :href="`/admin/checklist_categories/edit/${row.id}`"><i class="icon-fa icon-fa-pencil-square-o"/></a>
									<a v-on:click="deleteChecklistCategory(`${row.id}`)"><i class="icon-fa icon-fa-trash"/></a>
								</template>
							</table-column>
						</table-component>
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
								<router-link to="/admin/checklist_items/add" class="btn btn-success btn-xs float-right"><i class="icon-fa icon-fa-plus-circle"/>Add Item</router-link>
							</div>
						</div>  
					</div>
					<div class="card-body">
						<table-component :data="fetchChecklistsItemData" :show-filter="false" filter-placeholder="Search items.." filter-no-results="No items found!" table-class="table" ref="checklistItemTable">
							<table-column :sortable="false" :filterable="false" show="name" label="Name"/>
							<table-column :sortable="false" :filterable="false" show="organization.name" label="Organization"/>
							<table-column :sortable="false" :filterable="false" label="Actions">
								<template slot-scope="row">
									<a :href="`/admin/checklist_items/edit/${row.id}`"><i class="icon-fa icon-fa-pencil-square-o"/></a>
									<a v-on:click="deleteChecklistItem(`${row.id}`)"><i class="icon-fa icon-fa-trash"/></a>
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
    async fetchChecklistsAreaData ({ page, filter, sort }) {
      const response = await axios.get(`/api/admin/checklist_areas/get?page=${page}`)

      return {
        data: response.data.data,
        pagination: {
          totalPages: response.data.last_page,
          currentPage: page,
          count: response.data.count
        }
	  }
	},
	async fetchChecklistsTimeData ({ page, filter, sort }) {
      const response = await axios.get(`/api/admin/checklist_times/get?page=${page}`)

      return {
        data: response.data.data,
        pagination: {
          totalPages: response.data.last_page,
          currentPage: page,
          count: response.data.count
        }
	  }
	},
	async fetchChecklistsCategoryData ({ page, filter, sort }) {
      const response = await axios.get(`/api/admin/checklist_categories/get?page=${page}`)

      return {
        data: response.data.data,
        pagination: {
          totalPages: response.data.last_page,
          currentPage: page,
          count: response.data.count
        }
	  }
	},
	async fetchChecklistsItemData ({ page, filter, sort }) {
      const response = await axios.get(`/api/admin/checklist_items/get?page=${page}`)

      return {
        data: response.data.data,
        pagination: {
          totalPages: response.data.last_page,
          currentPage: page,
          count: response.data.count
        }
	  }
	},
	deleteChecklistArea(id){
		let app = this;
		notie.confirm({
			text: "Are you sure you want to delete this checklist area?",
			cancelCallback: function () {
				// notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
			},
			submitCallback: function () {
				axios.delete('/api/admin/checklist_areas/' + id)
				.then((resp) => {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while deleting the area. Please contact admin about this.', 'Error!');
					}
					else{
						toastr['success']('Checklist Area deleted!', 'Success!');
						app.$refs.checklistAreaTable.refresh();
					}
				})
				.catch((error) => {
					console.log("Error on ajax call!");
				});
			}
		});		
	},
	deleteChecklistTime(id){
		let app = this;
		notie.confirm({
			text: "Are you sure you want to delete this checklist time?",
			cancelCallback: function () {
				// notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
			},
			submitCallback: function () {
				axios.delete('/api/admin/checklist_times/' + id)
				.then((resp) => {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while deleting the time. Please contact admin about this.', 'Error!');
					}
					else{
						toastr['success']('Checklist Time deleted!', 'Success!');
						app.$refs.checklistTimeTable.refresh();
					}
				})
				.catch((error) => {
					console.log("Error on ajax call!");
				});
			}
		});			
	},
	deleteChecklistCategory(id){
		let app = this;
		notie.confirm({
			text: "Are you sure you want to delete this checklist category?",
			cancelCallback: function () {
				// notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
			},
			submitCallback: function () {
				axios.delete('/api/admin/checklist_categories/' + id)
				.then((resp) => {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while deleting the category. Please contact admin about this.', 'Error!');
					}
					else{
						toastr['success']('Checklist Category deleted!', 'Success!');
						app.$refs.checklistCategoryTable.refresh();
					}
				})
				.catch((error) => {
					console.log("Error on ajax call!");
				});
			}
		});			
	},
	deleteChecklistItem(id){
		let app = this;
		notie.confirm({
			text: "Are you sure you want to delete this checklist item?",
			cancelCallback: function () {
				// notie.alert({ type: 3, text: 'Aw, why not? :(', time: 2 })
			},
			submitCallback: function () {
				axios.delete('/api/admin/checklist_items/' + id)
				.then((resp) => {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while deleting the item. Please contact admin about this.', 'Error!');
					}
					else{
						toastr['success']('Checklist Item deleted!', 'Success!');
						app.$refs.checklistItemTable.refresh();
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