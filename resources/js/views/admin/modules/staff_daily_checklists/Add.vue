<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Staff Daily Checklists</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Add a Staff Daily Checklist</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/staff_daily_checklists" class="btn btn-dark btn-xs float-right">
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
							<label class="control-label">Time</label>
							<select class="form-control" v-model.trim="time_id" ref="time_id" required>
								<option v-for="checklistTime in checklistTimes" :value="checklistTime.id">
									{{checklistTime.name}}
								</option>
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
			organization_id: null,
			area_id: null,
			time_id: null,
			organizations: [],
			checklistTimes: [],
			checklistAreas: [],
			checkedItems: [],
			itemsData: [],
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
		},
		getChecklistTimesByOrganizationID() {
			let app = this;
			axios.get('/api/admin/checklist_times/getChecklistTimesByOrganizationID/' + app.organization_id)
			.then(function(resp) {
				app.checklistTimes = resp.data;
			})
			.catch(function() {
				console.log("Error fetching checklist time");
			});
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
		clearChecklistsDropdown() {
			let app = this;

			app.checklistTimes = [];
			app.checklistAreas = [];

			app.manageChecklistsData.organization_id = null;
			app.manageChecklistsData.time_id = null;
			app.manageChecklistsData.area_id = null;
		},
		getChecklistItems() {
			let app = this;

			axios.get(`/api/admin/manage_checklists/getChecklistItems?organization_id=${app.organization_id}&area_id=${app.area_id}&time_id=${app.time_id}`)
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
		saveChecklist() {
			let app = this;

			console.log(app.itemsData);
			console.log(app.checkedItems);

			

			// axios.post('/api/admin/manage_checklists', app.manageChecklistsData)
			// .then(function(resp) {
			// 	if(resp.data.status == 'error'){
			// 		toastr['error']('Something went wrong while adding the checklist. Please contact admin about this.', 'Error!');
			// 	}
			// 	else{
			// 		app.$router.push('/admin/manage_checklists');
			// 		toastr['success']('New checklist added!', 'Success!');
			// 	}
			// })
			// .catch(function() {
			// 	console.log("Error on ajax call!");
			// });
		},
		comparer(otherArray){
			return function(current){
				return otherArray.filter(function(other){
				return other.value == current.value && other.display == current.display
				}).length == 0;
			}
		}
	}
};
</script>
