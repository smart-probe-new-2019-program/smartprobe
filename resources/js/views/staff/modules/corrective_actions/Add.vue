<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Corrective Actions</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Add a Corrective Action</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/staff/corrective_actions" class="btn btn-dark btn-xs float-right">
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
							<label class="control-label">User</label>
							<select class="form-control" v-model.trim="correctiveActionsData.user_id" ref="user_id" required>
								<option v-for="user in users" :value="user.id">
									{{user.full_name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Comment Type</label>
							<select class="form-control" v-model="correctiveActionsData.comment_type" ref="comment_type" required>
								<option value="Individual Comment">Individual Comment</option>
								<option value="Group Comment">Group Comment</option>
							</select>
						</div>
					</div>
					<div class="row" v-if="correctiveActionsData.comment_type=='Group Comment'">
						<div class="col-sm-6 form-group">
							<label class="control-label">Comment</label>
							<textarea v-model.trim="correctiveActionsData.comment" class="form-control" rows="3" ref="comment"/>
						</div>
					</div>
					<div class="row" v-if="correctiveActionsData.comment_type=='Individual Comment'">
						<div class="col-sm-6 form-group" v-if="probes.length > 0">
							<div v-for="(individual_comment, index) in individual_comments" :value="individual_comment.probe_id" class="form-group">
								<label class="control-label">Comment for: <b>{{individual_comment.probe_name}} - {{individual_comment.probe_serial_number}}</b></label>
								<textarea v-model.trim="individual_comment.comment" class="form-control" rows="3" ref="comment"/>
							</div>
						</div>
						<div class="col-sm-6 form-group" v-else>
							<h5 style="color: red;">No Probes for this Organization!!</h5>
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
			correctiveActionsData: {
				organization_id: localStorage.getItem("user.organization_id"),
				user_id: "",
				comment_type: "",
				comment: "",
				created_by: localStorage.getItem("user.id"),
				updated_by: localStorage.getItem("user.id")
			},
			users: [],
			probes: [],
			individual_comments: {},
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

		this.getNeededDropdowns();
	},
	methods: {
		getNeededDropdowns() {
			let app = this;

			app.correctiveActionsData.user_id = null;
			app.correctiveActionsData.comment_type = null;

			app.getUsersByOrganizationID();
			app.getProbesByOrganizationID();
		},
		getUsersByOrganizationID() {
			let app = this;
			axios.get('/api/admin/users/getUsersByOrganizationID/'+ app.correctiveActionsData.organization_id)
			.then(function(resp) {
				app.users = resp.data;
			})
			.catch(function() {
				console.log("Error fetching users");
			});
		},
		getProbesByOrganizationID() {
			let app = this;
			axios.get('/api/admin/probes/getProbesByOrganizationID/'+ app.correctiveActionsData.organization_id)
			.then(function(resp) {
				app.probes = resp.data;

				if(app.probes.length > 0){
					app.individual_comments = {};
					for (let index = 0; index < app.probes.length; index++) {
						const probe = app.probes[index];
						app.individual_comments[index] = {'probe_id' : probe.id, 'probe_name': probe.name, 'probe_serial_number': probe.serial_number, 'comment': ''};
					}
				}
				else{

					app.individual_comments = {};
				}
			})
			.catch(function() {
				console.log("Error fetching probes");
			});
		},
		saveForm() {
			let app = this;
			let combinedArray = {};

			if(app.correctiveActionsData.comment_type == 'Group Comment'){
				axios.post('/api/admin/corrective_actions', app.correctiveActionsData)
				.then(function(resp) {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while adding the corrective actions. Please contact admin about this.', 'Error!');
					}
					else{
						app.$router.push('/staff/corrective_actions');
						toastr['success']('New corrective action added!', 'Success!');
					}
				})
				.catch(function() {
					console.log("Error on ajax call!");
				});
			}
			else{
				axios.post('/api/admin/corrective_actions', app.correctiveActionsData)
				.then(function(resp) {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while adding the corrective actions. Please contact admin about this.', 'Error!');
					}
					else{
						combinedArray.comments = app.individual_comments;
						combinedArray.corrective_action_id = resp.data.data.id;
						combinedArray.created_by = app.correctiveActionsData.created_by;
						combinedArray.updated_by = app.correctiveActionsData.updated_by;

						axios.post('/api/admin/individual_comments', combinedArray)
						.then(function(resp) {
							if(resp.data.status == 'error'){
								toastr['error']('Something went wrong while adding the individual comments. Please contact admin about this.', 'Error!');
							}
							else{
								app.$router.push('/staff/corrective_actions');
								toastr['success']('New corrective action added!', 'Success!');
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
		}
	}
};
</script>
