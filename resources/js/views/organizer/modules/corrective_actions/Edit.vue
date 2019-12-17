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
                <h5>Edit a Corrective Action</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/corrective_actions" class="btn btn-dark btn-xs float-right">
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
							<select class="form-control" v-model="correctiveActionsData.comment_type" ref="comment_type" required disabled>
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
						<div class="col-sm-6 form-group">
							<div v-for="(individual_comment, index) in individual_comments" :value="individual_comment.id" class="form-group">
								<label class="control-label">Comment for: {{individual_comment.probe.name}} - {{individual_comment.probe.serial_number}}</label>
								<textarea v-model.trim="individual_comment.comment" class="form-control" rows="3" ref="comment"/>
							</div>
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
			correctiveActionsData: {},
			users: [],
			individual_comments: {},
		};
	},
	mounted() {
		this.getCorrectiveAction();
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
		getCorrectiveAction() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/corrective_actions/getCorrectiveAction/' + id)
			.then(function(resp) {
				app.correctiveActionsData = resp.data;
				app.getNeededDropdowns();

				axios.get('/api/admin/individual_comments/getIndividualCommentsByCorrectiveActionID/' + id)
				.then(function(resp) {
					app.individual_comments = resp.data;					
				})
				.catch(function() {
					console.log("Error fetching individual comments data");
				});
			})
			.catch(function() {
				console.log("Error fetching corrective action data");
			});
		},
		getNeededDropdowns() {
			let app = this;

			app.getUsersByOrganizationID();
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
		saveForm() {
			let app = this;
			let combinedArray = {};
		
			app.correctiveActionsData.updated_by = localStorage.getItem("user.id"); //update user id of the one who edited
			
			if(app.correctiveActionsData.comment_type == 'Group Comment'){
				axios.patch('/api/admin/corrective_actions/' + app.correctiveActionsData.id, app.correctiveActionsData)
				.then(function(resp) {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while updating the corrective action. Please contact admin about this.', 'Error!');
					}
					else{
						app.$router.push('/organizer/corrective_actions');
						toastr['success']('Corrective action details updated!', 'Success!');
					}
				})
				.catch(function() {
					console.log("Error on ajax call!");
				});
			}
			else{
				axios.patch('/api/admin/corrective_actions/' + app.correctiveActionsData.id, app.correctiveActionsData)
				.then(function(resp) {
					if(resp.data.status == 'error'){
						toastr['error']('Something went wrong while updating the corrective action. Please contact admin about this.', 'Error!');
					}
					else{
						combinedArray.comments = app.individual_comments;
						combinedArray.corrective_action_id = app.correctiveActionsData.id;
						combinedArray.updated_by = app.correctiveActionsData.updated_by;

						axios.post('/api/admin/individual_comments/bulk_update', combinedArray)
						.then(function(resp) {
							if(resp.data.status == 'error'){
								toastr['error']('Something went wrong while updating the individual comments. Please contact admin about this.', 'Error!');
							}
							else{
								app.$router.push('/organizer/corrective_actions');
								toastr['success']('Corrective action updated!', 'Success!');
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