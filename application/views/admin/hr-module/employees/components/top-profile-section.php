<style>
/*---- Sidebar ----*/
.employee-profle-pic {
	height: 39px;
	width: 36px;
	background-color: #eaedf1;
	padding: 3px;
}
.dp-upload-btn{
	position: absolute;
	top: 20px;
	left: 0;
	right: 0px;
	width: 100px;
	height: 100px;
	margin: 0 auto;
	border-radius: 50%;
	color: #c9c9c900;
}
.dp-upload-btn:hover{
	position: absolute;
	top: 20px;
	left: 0;
	right: 0px;
	width: 100px;
	height: 100px;
	margin: 0 auto;
	border-radius: 50%;
	color: #000000;
    text-shadow: 2px 0px 2px #ffffff;
	font-size: 14px;
	font-weight: 700;
}
.uploadModal .modal-dialog-aside{
	width: 30%;
	max-width:80%; height: 100%; margin:0;
	transform: translate(0); transition: transform .2s;
}
.uploadModal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
.uploadModal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

.modal.show .modal-dialog-aside{ transform: translateX(0);  }
</style>
<div class="employee-profile-pic text-center">
							
	<div class="rounded-circle mb-2" style="width: 100px;margin: auto;">
		<?php if(!empty($emp_detail->employee_pic) && $emp_detail->employee_pic !== ''){ ?>
			<img id="profilePicture" src="<?php echo base_url($emp_detail->employee_pic); ?>" style="width: 100px;
height: 100px;
border: 3px solid #cfcdcd;
border-radius: 50%;
margin: auto;">
		<?php }else{ ?>
		<img id="profilePicture" src="<?php echo base_url('images/user-img.png'); ?>" style="width: 100px;
height: 100px;
border-radius: 50%;
margin: auto;">
		<?php } ?>
	</div>
	<button type="button" class="btn btn-link dp-upload-btn" data-bs-toggle="modal" data-bs-target=".uploadModal">
		Change Picture
	</button>
	<h5 id="employeeName"><?php echo $emp_detail->full_name; ?></h5>
</div>

<div class="modal fade fixed-left uploadModal" id="uploadModal" aria-labelledby="#uploadModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="uploadModalLabel">Update Profile Pic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<div id="uploadStatus" class="mb-2"></div>
				<form id="uploadForm" enctype="multipart/form-data">
					<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
					<div class="form-group">
						<label for="employee_pic">Choose Profile Picture:</label>
						<input type="file" name="employee_pic" id="employee_pic" class="dropify" 
					data-max-file-size="2M" data-height="100">

						<div id="cropControls" style="display:none;" class="mt-3 text-center">
							<button type="button" class="btn btn-primary" id="zoomIn">Zoom +</button>
							<button type="button" class="btn btn-primary" id="zoomOut">Zoom -</button>
							<button type="button" class="btn btn-warning" id="rotateLeft">Rotate ⟲</button>
							<button type="button" class="btn btn-warning" id="rotateRight">Rotate ⟳</button>
						</div>
						<div id="imagePreview" class="mt-3" style="display:none;">
							<img id="cropImage" style="max-width:80%;"/>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger" onclick="removeProfilePicture()">Remove Picture</button>
				<button type="button" class="btn btn-custom-success" id="uploadButton">Update Picture</button>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->