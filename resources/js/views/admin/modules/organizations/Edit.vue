<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Organizations</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Edit an Organization</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/organizations" class="btn btn-dark btn-xs float-right">
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
							<label class="control-label">Name</label>
							<input type="text" v-model.trim="organizationData.name" class="form-control" ref="name" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Description</label>
							<textarea v-model.trim="organizationData.description" class="form-control" rows="3" ref="description"/>
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
			organizationData: {},
		};
	},
	mounted() {
		this.getOrganization();
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
		getOrganization() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/organizations/getOrganization/' + id)
			.then(function(resp) {
				app.organizationData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching organization data");
			});
		},
		saveForm() {
			let app = this;
		
			app.organizationData.updated_by = localStorage.getItem("user.id"); //update user id of the one who edited
			axios.patch('/api/admin/organizations/' + app.organizationData.id, app.organizationData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while updating the organization. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/admin/organizations');
					toastr['success']('Organization details updated!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
			
		}
	}
};
</script>