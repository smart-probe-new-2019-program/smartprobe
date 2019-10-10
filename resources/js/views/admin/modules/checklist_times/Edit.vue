<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Checklist Times</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Edit an Area</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/checklist_times" class="btn btn-dark btn-xs float-right">
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
							<label class="control-label">Organization</label>
							<select class="form-control" v-model.trim="checklistTimeData.organization_id" ref="organization_id" required>
								<option v-for="organization in organizations" :value="organization.id">
									{{organization.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Name</label>
							<input type="text" v-model.trim="checklistTimeData.name" class="form-control" ref="name" required>
						</div>
					</div>
				</div>

				<div class="col-xs-12 form-group">
					<button class="btn btn-sm btn-success"><i class="icon-fa icon-fa-floppy-o"/> Save</button>
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
			checklistTimeData: {},
			organizations: [],
		};
	},
	mounted() {
		this.getChecklistTime();
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
		getChecklistTime() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/checklist_times/getChecklistTime/' + id)
			.then(function(resp) {
				app.checklistTimeData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching checklist time data");
			});
		},
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
		saveForm() {
			let app = this;
		
			app.checklistTimeData.updated_by = localStorage.getItem("user.id"); //update user id of the one who edited
			axios.patch('/api/admin/checklist_times/' + app.checklistTimeData.id, app.checklistTimeData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while updating the checklist time. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/admin/checklist_times');
					toastr['success']('Checklist time details updated!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
			
		}
	}
};
</script>