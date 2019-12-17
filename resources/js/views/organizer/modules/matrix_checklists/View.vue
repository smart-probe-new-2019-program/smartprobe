<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Matrix Checklists</h3>
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
                <router-link to="/organizer/matrix_checklists" class="btn btn-dark btn-xs float-right">
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
										<td> Area </td>
										<td> <b> {{area}} </b> </td>
									</tr>
									<tr> 
										<td> Day of the Week </td>
										<td> <b> {{day_of_the_week}} </b> </td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<tbody>
									<tr>
										<td><b>Items</b></td>
										<td><b>Value</b></td>
									</tr>
									<tr v-for="data in matrixChecklistItemData"> 
										<td> {{data.manage_checklist.item.name}} </td>
										<td v-if="data.value=='Checked'"> <b style="color: green;"> <i class="icon-fa icon-fa-check" aria-hidden="true"></i> </b> </td>
										<td v-else> <b style="color: red;"> <i class="icon-fa icon-fa-times" aria-hidden="true"></i> </b> </td>
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
			matrixChecklistItemData: {},
			area: '',
			day_of_the_week: '',
		};
	},
	mounted() {
		this.getStaffDailyChecklist();
	},
	methods: {
		getStaffDailyChecklist() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/matrix_checklists_items/getMatrixChecklistsItemsByMatrixChecklistsID/' + id)
			.then(function(resp) {
				app.matrixChecklistItemData = resp.data;
				app.area = app.matrixChecklistItemData[0].manage_checklist.area.name;
				app.day_of_the_week = app.matrixChecklistItemData[0].manage_checklist.day_of_the_week;
			})
			.catch(function() {
				console.log("Error fetching matrix checklist data");
			});
		}
	}
};
</script>