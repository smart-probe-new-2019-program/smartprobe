<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Matrix Checklists</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Add a Matrix Checklist</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/matrix_checklists" class="btn btn-dark btn-xs float-right">
                  <i class="icon-fa icon-fa-arrow-left"></i>Back
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">     
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3 form-group">
							<label class="control-label">Organization</label>
							<select class="form-control" @change="getChecklistsDropdown()" v-model.trim="organization_id" ref="organization_id" required>
								<option v-for="organization in organizations" :value="organization.id">
									{{organization.name}}
								</option>
							</select>
						</div>
						<div class="col-sm-3 form-group">
							<label class="control-label">Area</label>
							<select class="form-control" v-model.trim="area_id" ref="area_id" required>
								<option v-for="checklistArea in checklistAreas" :value="checklistArea.id">
									{{checklistArea.name}}
								</option>
							</select>
						</div>
						<div class="col-sm-3 form-group">
							<label class="control-label">Day of the Week</label>
							<select class="form-control" v-model="day_of_the_week" ref="day_of_the_week" required>
								<option value="Sunday">Sunday</option>
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
								<option value="Saturday">Saturday</option>
							</select>
						</div>
						<div class="col-sm-3 form-group" style="margin: auto;">
							<button @click="getChecklistItems()" class="btn btn-sm btn-success"><i class="icon-fa icon-fa-check"/> Select</button>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-sm-10">
						<div class="card">
							<h5 class="card-header">Checklist Items</h5>
							<div class="card-body">
								<h6 v-if="itemsData.length == 0"><font color="red">No Checklist Items!</font></h6>
								<div v-else v-for="itemData in itemsData" :key="itemData.id" class="custom-control custom-checkbox mb-3">
									<input type="checkbox" v-model="checkedItems" :value="itemData"> {{itemData.item.name}}
								</div>
								<div v-if="itemsData.length != 0">
									<button @click="saveChecklist()" class="btn btn-sm btn-success"><i class="icon-fa icon-fa-save"/> Submit</button>
								</div>
							</div>
						</div>
					</div>
				</div>
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
			matrixChecklistData: {
				organization_id: "",
				created_by: localStorage.getItem("user.id"),
				updated_by: localStorage.getItem("user.id")
			},
			organization_id: null,
			area_id: null,
			day_of_the_week: null,
			organizations: [],
			checklistAreas: [],
			checkedItems: [],
			itemsData: {},
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

			app.checklistAreas = [];
			app.itemsData = {};
			app.checkedItems = [];
			app.area_id = null;
			app.day_of_the_week = null;
			
			app.getChecklistAreasByOrganizationID();
		},
		getChecklistAreasByOrganizationID() {
			let app = this;
			axios.get('/api/admin/checklist_areas/getChecklistAreasByOrganizationID/' + app.organization_id)
			.then(function(resp) {
				app.checklistAreas = resp.data;
			})
			.catch(function() {
				console.log("Error fetching checklist areas");
			});
		},
		getChecklistItems() {
			let app = this;

			axios.get(`/api/admin/manage_checklists/getMatrixChecklistItems?organization_id=${app.organization_id}&area_id=${app.area_id}&day_of_the_week=${app.day_of_the_week}`)
			.then(function(resp) {
				app.itemsData = resp.data;

				if(app.itemsData.length == 0){
					toastr['error']('No checklist items found.', 'Error!');
				}
				else{
					toastr['success']('Checklist items found.', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error fetching checklist data");
			});
		},
		getUncheckedItems(itemsData, checkedItems) {
			let result = [];

			result = itemsData.filter(o => !checkedItems.some(v => v.id === o.id));
			
			return result;
		},
		saveChecklist() {
			let app = this;
			let checkedItems = app.checkedItems;
			let uncheckedItems = app.getUncheckedItems(app.itemsData, app.checkedItems);
			
			app.matrixChecklistData.organization_id = app.organization_id;
			
			if(checkedItems.length > 0){
				axios.post('/api/admin/matrix_checklists', app.matrixChecklistData)
				.then(function(resp) {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while adding the matrix checklist. Please contact admin about this.', 'Error!');
					}
					else{
						let combinedArray = {'matrix_checklists_id':resp.data.data.id, 'checkedItems':checkedItems, 'uncheckedItems':uncheckedItems, 'created_by':localStorage.getItem("user.id"), 'updated_by':localStorage.getItem("user.id")};
						
						axios.post('/api/admin/matrix_checklists_items', combinedArray)
						.then(function(resp) {
							if(resp.data.status == 'error'){
								toastr['error']('Something went wrong while adding the matrix checklist items. Please contact admin about this.', 'Error!');
							}
							else{				
								app.$router.push('/admin/matrix_checklists');
								toastr['success']('New matrix checklist added!', 'Success!');
							}
						})
						.catch(function() {
							console.log("Error on ajax call!");
						});
					}
				})
				.catch(function() {
					console.log("Error on ajax call!");
				});
			}
			else{
				toastr['warning']('Please select atleast 1 item on the checklist!', 'Warning!');
			}
			
		}
	}
};
</script>
