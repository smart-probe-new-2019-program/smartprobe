<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Items</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Edit an Item</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/admin/incoming_deliveries_items" class="btn btn-dark btn-xs float-right">
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
							<label class="control-label">Organization</label>
							<select class="form-control" v-model.trim="itemData.organization_id" ref="organization_id" required>
								<option v-for="organization in organizations" :value="organization.id">
									{{organization.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Name</label>
							<input type="text" v-model.trim="itemData.name" class="form-control" ref="name" required>
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
			itemData: {},
			organizations: [],
		};
	},
	mounted() {
		this.getItem();
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
		getItem() {
			let app = this;
			let id = app.$route.params.id;
			axios.get('/api/admin/incoming_deliveries_items/getIncomingDeliveriesItem/' + id)
			.then(function(resp) {
				app.itemData = resp.data;
			})
			.catch(function() {
				console.log("Error fetching item data");
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
		saveForm() {
			let app = this;
		
			app.itemData.updated_by = localStorage.getItem("user.id"); //update user id of the one who edited
			axios.patch('/api/admin/incoming_deliveries_items/' + app.itemData.id, app.itemData)
			.then(function(resp) {
				if(resp.data.status == 'error'){
					toastr['error']('Something went wrong while updating the item. Please contact admin about this.', 'Error!');
				}
				else{
					app.$router.push('/admin/incoming_deliveries_items');
					toastr['success']('Item details updated!', 'Success!');
				}
			})
			.catch(function() {
				console.log("Error on ajax call!");
			});
			
		}
	}
};
</script>