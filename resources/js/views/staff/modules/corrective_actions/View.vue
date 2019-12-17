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
                <h5>View a Corrective Action</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/staff/corrective_actions" class="btn btn-dark btn-xs float-right">
                  <i class="icon-fa icon-fa-arrow-left"></i>Back
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">  
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<tbody>
									<tr> 
										<td> User </td>
										<td> <b> {{correctiveActionsData.user.full_name}} </b> </td>
									</tr>
									<tr> 
										<td> Comment Type </td>
										<td> <b> {{correctiveActionsData.comment_type}} </b> </td>
									</tr>
									<tr v-if="correctiveActionsData.comment_type == 'Group Comment'"> 
										<td> Comment </td>
										<td> <b> {{correctiveActionsData.comment}} </b> </td>
									</tr>
									<tr v-else v-for="(individual_comment, index) in individual_comments" :value="individual_comment.id"> 
										<td> Comment for: <b>{{individual_comment.probe.name}} - {{individual_comment.probe.serial_number}}</b></td>
										<td> <b> {{individual_comment.comment}} </b> </td>
									</tr>
								</tbody>
							</table>
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
			correctiveActionsData: {},
			individual_comments: {},
		};
	},
	mounted() {
		this.getCorrectiveAction();
	},
	methods: {
		getCorrectiveAction() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/corrective_actions/' + id)
			.then(function(resp) {
				app.correctiveActionsData = resp.data;

				axios.get('/api/admin/individual_comments/getIndividualCommentsByCorrectiveActionID/' + id)
				.then(function(resp) {
					app.individual_comments = resp.data;					
				})
				.catch(function() {
					console.log("Error fetching individual comments data");
				});
			})
			.catch(function() {
				console.log("Error fetching corrective actions data");
			});
		}
	}
};
</script>