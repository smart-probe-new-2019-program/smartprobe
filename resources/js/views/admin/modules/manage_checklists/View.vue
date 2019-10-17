<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Manage Checklists</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>View a Checklist</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/manage_checklists" class="btn btn-dark btn-xs float-right">
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
										<td> Checklist Type </td>
										<td> <b> {{manageChecklistsData.type}} </b> </td>
									</tr>
									<tr> 
										<td> Organization </td>
										<td> <b> {{manageChecklistsData.organization.name}} </b> </td>
									</tr>
									<tr v-if="manageChecklistsData.type!='Matrix Checklists'"> 
										<td> Time </td>
										<td> <b> {{manageChecklistsData.time.name}} </b> </td>
									</tr>
									<tr> 
										<td> Area </td>
										<td> <b> {{manageChecklistsData.area.name}} </b> </td>
									</tr>
									<tr v-if="manageChecklistsData.type=='Matrix Checklists'"> 
										<td> Day of the Week </td>
										<td> <b> {{manageChecklistsData.day_of_the_week}} </b> </td>
									</tr>
									<tr v-if="manageChecklistsData.type!='Matrix Checklists'"> 
										<td> Category </td>
										<td> <b> {{manageChecklistsData.category.name}} </b> </td>
									</tr>
									<tr> 
										<td> Item </td>
										<td> <b> {{manageChecklistsData.item.name}} </b> </td>
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
			manageChecklistsData: {},
		};
	},
	mounted() {
		this.getManageChecklist();
	},
	methods: {
		getManageChecklist() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/manage_checklists/' + id)
			.then(function(resp) {
				app.manageChecklistsData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching manage checklist data");
			});
		}
	}
};
</script>