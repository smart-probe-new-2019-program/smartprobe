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
							<label class="control-label">Process</label>
							<select class="form-control" v-model.trim="userData.process" ref="process" required>
								<option v-for="process in processes" :value="process.id">
									{{process.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Shift</label>
							<select class="form-control" v-model="userData.shift" ref="shift" required>
								<option v-for="shift in shifts" :value="shift.id">
									{{shift.shift_name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Production Line</label>
							<select class="form-control" v-model="userData.line" ref="line" required>
								<option v-for="line in lines" :value="line.id">
									{{line.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Role</label>
							<select class="form-control" v-model="userData.role" ref="role" required>
								<option value="admin">Admin</option>
								<option value="user">User</option>
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
			processes: [],
			shifts: [],
			lines: [],
		};
	},
	mounted() {
		this.getUser();
		this.getProcesses();
		this.getShifts();
		this.getLines();
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
			})
			.catch(function() {
				console.log("Error fetching user data");
			});
		},
		getProcesses() {
			let app = this;
			axios.get('/api/admin/process/getProcessesForDropdown')
			.then(function(resp) {
				app.processes = resp.data;
			})
			.catch(function() {
				console.log("Error fetching processes");
			});
		},
		getShifts() {
			let app = this;
			axios.get('/api/admin/shifts/getShiftsForDropdown')
			.then(function(resp) {
				app.shifts = resp.data;
			})
			.catch(function() {
				console.log("Error fetching shifts");
			});
		},
		getLines() {
			let app = this;
			axios.get('/api/admin/production_lines/getProductionLinesForDropdown')
			.then(function(resp) {
				app.lines = resp.data;
			})
			.catch(function() {
				console.log("Error fetching lines");
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