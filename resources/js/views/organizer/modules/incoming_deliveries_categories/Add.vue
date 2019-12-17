<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Categories</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Add a Category</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/incoming_deliveries_categories" class="btn btn-dark btn-xs float-right">
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
							<input type="text" v-model.trim="categoryData.name" class="form-control" ref="name" required>
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
			categoryData: {
				organization_id: localStorage.getItem("user.organization_id"),
				name: "",
				created_by: localStorage.getItem("user.id"),
				updated_by: localStorage.getItem("user.id")
			},
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
	},
	methods: {
		saveForm() {
			let app = this;
		
			axios.post('/api/admin/incoming_deliveries_categories', app.categoryData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while adding the category. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/organizer/incoming_deliveries_categories');
					toastr['success']('New category added!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
		}
	}
};
</script>
