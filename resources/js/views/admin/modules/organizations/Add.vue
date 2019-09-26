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
                <h5>Add an Organization</h5>
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
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Address</label>
							<input type="text" v-model.trim="organizationData.address" class="form-control" ref="address" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">City</label>
							<input type="text" v-model.trim="organizationData.city" class="form-control" ref="city" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Country</label>
							<input type="text" v-model.trim="organizationData.country" class="form-control" ref="country" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">State</label>
							<input type="text" v-model.trim="organizationData.state" class="form-control" ref="state">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Zip Code</label>
							<input type="text" v-model.trim="organizationData.zip_code" class="form-control" ref="zip_code">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Email</label>
							<input type="email" v-model.trim="organizationData.email" class="form-control" ref="email" required>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Office Phone</label>
							<input type="text" v-model.trim="organizationData.office_phone" class="form-control" ref="office_phone">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Office Fax</label>
							<input type="text" v-model.trim="organizationData.office_fax" class="form-control" ref="office_fax">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Mobile Phone</label>
							<input type="text" v-model.trim="organizationData.mobile_phone" class="form-control" ref="mobile_phone">
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
			organizationData: {
				name: "",
				description: "",
				address: "",
				city: "",
				country: "",
				state: "",
				zip_code: "",
				office_phone: "",
				office_fax: "",
				mobile_phone: "",
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
		
			axios.post('/api/admin/organizations', app.organizationData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while adding the organization. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/admin/organizations');
					toastr['success']('New organization added!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
		}
	}
};
</script>
