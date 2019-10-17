<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Manage Checklists</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Add a Checklist</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/manage_checklists" class="btn btn-dark btn-xs float-right">
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
							<label class="control-label">Checklist Type</label>
							<select class="form-control" @change="clearChecklistsDropdown()" v-model="manageChecklistsData.type" ref="type" required>
								<option value="Staff Daily Checklists">Staff Daily Checklists</option>
								<option value="Cleaning - Hygiene">Cleaning - Hygiene</option>
								<option value="Pest Control - Daily - Quarterly">Pest Control - Daily - Quarterly</option>
								<option value="Equipment">Equipment</option>
								<option value="Misc Procedures">Misc Procedures</option>
								<option value="Staff Manuals and Procedures">Staff Manuals and Procedures</option>
								<option value="Matrix Checklists">Matrix Checklists</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Organization</label>
							<select class="form-control"  @change="getChecklistsDropdown()" v-model.trim="manageChecklistsData.organization_id" ref="organization_id" required>
								<option v-for="organization in organizations" :value="organization.id">
									{{organization.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row" v-if="manageChecklistsData.type!='Matrix Checklists'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Time</label>
							<select class="form-control" v-model.trim="manageChecklistsData.time_id" ref="time_id" required>
								<option v-for="checklistTime in checklistTimes" :value="checklistTime.id">
									{{checklistTime.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Area</label>
							<select class="form-control" v-model.trim="manageChecklistsData.area_id" ref="area_id" required>
								<option v-for="checklistArea in checklistAreas" :value="checklistArea.id">
									{{checklistArea.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row" v-if="manageChecklistsData.type=='Matrix Checklists'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Day of the Week</label>
							<select class="form-control" v-model="manageChecklistsData.day_of_the_week" ref="day_of_the_week" required>
								<option value=""></option>
								<option value="Sunday">Sunday</option>
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
								<option value="Saturday">Saturday</option>
							</select>
						</div>
					</div>
					<div class="row" v-if="manageChecklistsData.type!='Matrix Checklists'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Category</label>
							<select class="form-control" v-model.trim="manageChecklistsData.category_id" ref="category_id" required>
								<option v-for="checklistCategory in checklistCategories" :value="checklistCategory.id">
									{{checklistCategory.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Item</label>
							<select class="form-control" v-model.trim="manageChecklistsData.item_id" ref="item_id" required>
								<option v-for="checklistItem in checklistItems" :value="checklistItem.id">
									{{checklistItem.name}}
								</option>
							</select>
						</div>
					</div>
				</div>
			
				<div class="col-xs-12 form-group">
					<button class="btn btn-sm btn-success"><i class="icon-fa icon-fa-plus-circle"/> Create</button>
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
			manageChecklistsData: {
				type: null,
				organization_id: null,
				time_id: null,
				area_id: null,
				day_of_the_week: null,
				category_id: null,
				item_id: null,
				created_by: localStorage.getItem("user.id"),
				updated_by: localStorage.getItem("user.id")
			},
			organizations: [],
			checklistTimes: [],
			checklistAreas: [],
			checklistCategories: [],
			checklistItems: [],
		};
	},
	mounted() {
		this.getOrganizations();
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
	methods: {
		getOrganizations() {
			let app = this;
			axios.get('/api/admin/organizations/getOrganizationsForDropdown')
			.then(function(resp) {
				app.organizations = resp.data;
			})
			.catch(function() {
				console.log("Error fetching organizations");
			});
		},
		getChecklistsDropdown() {
			let app = this;

			app.getChecklistTimesByOrganizationID();
			app.getChecklistAreasByOrganizationID();
			app.getChecklistCategoriesByOrganizationID();
			app.getChecklistItemsByOrganizationID();
		},
		getChecklistTimesByOrganizationID() {
			let app = this;
			axios.get('/api/admin/checklist_times/getChecklistTimesByOrganizationID/' + app.manageChecklistsData.organization_id)
			.then(function(resp) {
				app.checklistTimes = resp.data;
			})
			.catch(function() {
				console.log("Error fetching checklist time");
			});
		},
		getChecklistAreasByOrganizationID() {
			let app = this;
			axios.get('/api/admin/checklist_areas/getChecklistAreasByOrganizationID/' + app.manageChecklistsData.organization_id)
			.then(function(resp) {
				app.checklistAreas = resp.data;
			})
			.catch(function() {
				console.log("Error fetching checklist areas");
			});
		},
		getChecklistCategoriesByOrganizationID() {
			let app = this;
			axios.get('/api/admin/checklist_categories/getChecklistCategoriesByOrganizationID/' + app.manageChecklistsData.organization_id)
			.then(function(resp) {
				app.checklistCategories = resp.data;
			})
			.catch(function() {
				console.log("Error fetching checklist categories");
			});
		},
		getChecklistItemsByOrganizationID() {
			let app = this;
			axios.get('/api/admin/checklist_items/getChecklistItemsByOrganizationID/' + app.manageChecklistsData.organization_id)
			.then(function(resp) {
				app.checklistItems = resp.data;
			})
			.catch(function() {
				console.log("Error fetching checklist items");
			});
		},
		clearChecklistsDropdown() {
			let app = this;

			app.checklistTimes = [];
			app.checklistAreas = [];
			app.checklistCategories = [];
			app.checklistItems = [];

			app.manageChecklistsData.organization_id = null;
			app.manageChecklistsData.time_id = null;
			app.manageChecklistsData.area_id = null;
			app.manageChecklistsData.day_of_the_week = null;
			app.manageChecklistsData.category_id = null;
			app.manageChecklistsData.item_id = null;
		},
		saveForm() {
			let app = this;
		
			axios.post('/api/admin/manage_checklists', app.manageChecklistsData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while adding the checklist. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/admin/manage_checklists');
					toastr['success']('New checklist added!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
		}
	}
};
</script>
