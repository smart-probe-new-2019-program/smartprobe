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
                <h5>Edit User</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/users" class="btn btn-dark btn-xs float-right">
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
							<label class="control-label">Firstname</label>
							<input type="text" v-model.trim="userData.first_name" class="form-control" ref="first_name" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Lastname</label>
							<input type="text" v-model.trim="userData.last_name" class="form-control" ref="last_name" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Email</label>
							<input type="email" v-model.trim="userData.email" class="form-control" ref="email" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Username</label>
							<input type="text" v-model.trim="userData.username" class="form-control" ref="username" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Password <font color="red">(Just leave this blank if you do not want to change the password)</font></label>
							<input type="password" v-model.trim="userData.password" class="form-control" ref="password">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Role</label>
							<select class="form-control" v-model="userData.role" ref="role" required>
								<option value="Admin">Admin</option>
								<option value="Organizer">Organizer</option>
								<option value="Manager">Manager</option>
								<option value="Staff">Staff</option>
							</select>
						</div>
					</div>
					<div class="row" v-if="userData.role=='Organizer' || userData.role=='Manager' || userData.role=='Staff'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Organization</label>
							<select @change="getLocations(userData.organization_id)" class="form-control" v-model="userData.organization_id" ref="organization_id" required>
								<option v-for="organization in organizations" :value="organization.id">
									{{organization.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row" v-if="userData.role=='Manager' || userData.role=='Staff'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Location</label>
							<select class="form-control" v-model="userData.location_id" ref="location_id" required>
								<option v-for="location in locations" :value="location.id">
									{{location.name}}
								</option>
							</select>
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
			userData: {},
			organizations: [],
			locations: [],
		};
	},
	mounted() {
		this.getUser();
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
		getUser() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/users/getUser/' + id)
			.then(function(resp) {
				app.userData = resp.data;
				app.getLocations(app.userData.organization_id);
			})
			.catch(function() {
				console.log("Error fetching user data");
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
		getLocations(organization_id) {
			let app = this;
			axios.get('/api/admin/locations/getLocationsByOrganizationID/' + organization_id)
			.then(function(resp) {
				app.locations = resp.data;
			})
			.catch(function() {
				console.log("Error fetching locations");
			});
		},
		saveForm() {
			let app = this;
		
			app.userData.updated_by = localStorage.getItem("user.id"); //update user id of the one who edited
			axios.patch('/api/admin/users/' + app.userData.id, app.userData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					if(resp.data.data == 'Duplicate Email'){
						toastr['error']('Email already taken.', 'Error!');
						app.$refs.email.focus();
					}
					else if(resp.data.data == 'Duplicate Username'){
						toastr['error']('Username already taken!', 'Error!');
						app.$refs.username.focus()
					}
					else{
						toastr['error']('Something went wrong while updating the user. Please contact admin about this.', 'Error!');
					}
				}
				else{
					app.$router.push('/admin/users');
					toastr['success']('User details updated!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
			
		}
	}
};
</script>