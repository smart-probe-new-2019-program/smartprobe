<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">File Entries</h3>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Add a File/s</h5>
              </div>
              <div class="col-sm-6">
                <router-link to="/organizer/file_entries" class="btn btn-dark btn-xs float-right">
                  <i class="icon-fa icon-fa-arrow-left"></i>Back
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body">
			   <div class="container">	
					<div class="large-12 medium-12 small-12 filezone">
						<input type="file" id="files" ref="files" multiple v-on:change="handleFiles()"/>
						<p>
							Drop your files here <br>or click to search
						</p>
					</div>
					<br />
					<div v-for="(file, key) in files" class="file-listing">
						<img class="preview" v-bind:ref="'preview'+parseInt(key)"/>
						{{ file.name }}
						<div class="success-container" v-if="file.id > 0">
							Success
						</div>
						<div class="remove-container" v-else>
							<a v-on:click="removeFile(key)"><i class="icon-fa icon-fa-trash"/></a>
						</div>
					</div>
					<br />
					<button v-show="files.length > 0" v-on:click="submitFiles()" class="btn btn-sm btn-success"><i class="icon-fa icon-fa-upload"/> Upload</button>
					
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
			files: [],
			organization_id: localStorage.getItem("user.organization_id"),
		}
	},
	mounted() {
	},
	methods: {
		handleFiles() {
			let uploadedFiles = this.$refs.files.files;

			for(var i = 0; i < uploadedFiles.length; i++) {
				this.files.push(uploadedFiles[i]);
			}
			this.getImagePreviews();
		},
		getImagePreviews(){
			for( let i = 0; i < this.files.length; i++ ){
				if ( /\.(jpe?g|png|gif)$/i.test( this.files[i].name ) ) {
					let reader = new FileReader();
					reader.addEventListener("load", function(){
						this.$refs['preview'+parseInt(i)][0].src = reader.result;
					}.bind(this), false);
					reader.readAsDataURL( this.files[i] );
				}else{
					this.$nextTick(function(){
						this.$refs['preview'+parseInt(i)][0].src = '/img/generic.png';
					});
				}
			}
		},
		removeFile( key ){
			this.files.splice( key, 1 );
			this.getImagePreviews();
		},
		submitFiles() {
			let app = this;
			let errorCount = 0;
			for( let i = 0; i < app.files.length; i++ ){
				if(app.files[i].id) {
					continue;
				}

				let formData = new FormData();
				formData.append('file', app.files[i]);
				formData.append('organization_id', app.organization_id);
				formData.append('created_by', localStorage.getItem("user.id"));
				formData.append('updated_by', localStorage.getItem("user.id"));

				axios.post('/api/admin/file_entries', 
					formData,
					{
						headers: {
							'Content-Type': 'multipart/form-data'
						}
					}
				)
				.then(function(resp) {
					if(resp.data.status == 'error'){
						errorCount++;
					}
				})
				.catch(function() {
					if(resp.data.status == 'error'){
						errorCount++;
					}
				});
			}

			if(errorCount == 0){
				app.$router.push('/organizer/file_entries');
				toastr['success']('New File/s added!', 'Success!');
			}
			else{
				toastr['error']('Something went wrong while adding the individual comments. Please contact admin about this.', 'Error!');
			}
			
		}
	}
};
</script>

<style scoped>
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 200px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: #ccc;
        color: dimgray;
        padding: 10px 10px;
        min-height: 200px;
        position: relative;
        cursor: pointer;
    }
    .filezone:hover {
        background: #c0c0c0;
    }

    .filezone p {
        font-size: 1.2em;
        text-align: center;
        padding: 50px 50px 50px 50px;
    }
    div.file-listing img{
        max-width: 90%;
    }

    div.file-listing{
        margin: auto;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    div.file-listing img{
        height: 100px;
    }
    div.success-container{
        text-align: center;
        color: green;
    }

    div.remove-container{
        text-align: center;
    }

    div.remove-container a{
        color: red;
        cursor: pointer;
    }

    a.submit-button{
        display: block;
        margin: auto;
        text-align: center;
        width: 200px;
        padding: 10px;
        text-transform: uppercase;
        background-color: #CCC;
        color: white;
        font-weight: bold;
        margin-top: 20px;
    }
</style>
