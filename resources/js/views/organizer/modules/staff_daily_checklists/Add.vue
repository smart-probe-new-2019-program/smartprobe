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
                <router-link to="/organizer/staff_daily_checklists" class="btn btn-dark btn-xs float-right">
                  <i class="icon-fa icon-fa-arrow-left"></i>Back
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">     
				<div class="panel-body">
					<div class="row">
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
			staffDailyChecklistData: {
				organization_id: localStorage.getItem("user.organization_id"),
				created_by: localStorage.getItem("user.id"),
				updated_by: localStorage.getItem("user.id")
			},
			organization_id: localStorage.getItem("user.organization_id"),
			area_id: null,
			time_id: null,
			organizations: [],
			checklistTimes: [],
			checklistAreas: [],
			checkedItems: [],
			itemsData: {},
		};
	},
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

		this.getChecklistsDropdown();
	},
	methods: {
		getChecklistsDropdown() {
			let app = this;

			app.checklistTimes = [];
			app.checklistAreas = [];
			app.itemsData = {};
			app.checkedItems = [];
			app.area_id = null;
			app.time_id = null;
			
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
		getUncheckedItems(itemsData, checkedItems) {
			let result = [];

			result = itemsData.filter(o => !checkedItems.some(v => v.id === o.id));
			
			return result;
		},
		saveChecklist() {
			let app = this;
			let checkedItems = app.checkedItems;
			let uncheckedItems = app.getUncheckedItems(app.itemsData, app.checkedItems);
			
			app.staffDailyChecklistData.organization_id = app.organization_id;
			
			if(checkedItems.length > 0){
				axios.post('/api/admin/staff_daily_checklists', app.staffDailyChecklistData)
				.then(function(resp) {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while adding the staff daily checklist. Please contact admin about this.', 'Error!');
					}
					else{
						let combinedArray = {'staff_daily_checklists_id':resp.data.data.id, 'checkedItems':checkedItems, 'uncheckedItems':uncheckedItems, 'created_by':localStorage.getItem("user.id"), 'updated_by':localStorage.getItem("user.id")};
						
						axios.post('/api/admin/staff_daily_checklists_items', combinedArray)
						.then(function(resp) {
							if(resp.data.status == 'error'){
								toastr['error']('Something went wrong while adding the staff daily checklist items. Please contact admin about this.', 'Error!');
							}
							else{				
								app.$router.push('/organizer/staff_daily_checklists');
								toastr['success']('New staff daily checklist added!', 'Success!');
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
