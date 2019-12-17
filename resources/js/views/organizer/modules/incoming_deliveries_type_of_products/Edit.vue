<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Type Of Products</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Edit a Type</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/incoming_deliveries_type_of_products" class="btn btn-dark btn-xs float-right">
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
							<input type="text" v-model.trim="typeOfProductData.name" class="form-control" ref="name" required>
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
			typeOfProductData: {},
		};
	},
	mounted() {
		this.getType();
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
		getType() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/id_type_of_products/getIncomingDeliveriesTypeOfProduct/' + id)
			.then(function(resp) {
				app.typeOfProductData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching type data");
			});
		},
		saveForm() {
			let app = this;
		
			app.typeOfProductData.updated_by = localStorage.getItem("user.id"); //update user id of the one who edited
			axios.patch('/api/admin/id_type_of_products/' + app.typeOfProductData.id, app.typeOfProductData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while updating the type. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/organizer/incoming_deliveries_type_of_products');
					toastr['success']('Type details updated!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
			
		}
	}
};
</script>