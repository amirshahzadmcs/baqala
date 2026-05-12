<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Rider Detail</div>
    <div class="d-flex align-items-center employee-detail">
        <div class="image">
			<?php if(!empty($emp_detail['employee_pic']) && $emp_detail['employee_pic'] !== ''){ ?>
				<img src="<?php echo $emp_detail['employee_pic'];?>" class="rounded" width="140">
			<?php }else{ ?>
				<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
			<?php } ?>
        </div>
        <div class="p-3 w-100">
            <h5 class="mb-0 mt-0"> <?php echo $emp_detail['full_name'];?> / <?php echo $emp_detail['employee_arabic_name'];?> </h5>
            <span><?php echo $emp_detail['designation_name'];?> | <?php echo $emp_detail['department_name'];?></span>
            <hr class="my-1">
            <table>
                <tr>
                    <td>Emp No.</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['emp_no'];?></td>
                </tr>
				<tr>
                    <td>Nationality</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['nationality_name'];?></td>
                </tr>
                <tr>
                    <td>Flex Number</td>
                    <td> : </td>
                    <td><?php echo (!empty($sim_detail['mobile'])) ? $sim_detail['mobile'] : 'NA';?></td>
                </tr>
                <tr>
                    <td>Mobile No</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['mobile'];?></td>
                </tr>
				<tr>
                    <td>DL Number</td>
                    <td> : </td>
                    <td><?php if(!empty($other_detail['driving_license_number'])){ echo $other_detail['driving_license_number'];}else{ echo 'NA';}?></td>
                </tr>
                <tr>
                    <td>Vehicle No</td>
                    <td> : </td>
                    <td><?php if(!empty($vehicle_detail['vehicle_no'])){ echo $vehicle_detail['vehicle_no'];?> / <?php echo $vehicle_detail['vehicle_model'];?> / <?php echo $vehicle_detail['make_name'];?> <?php echo ($vehicle_detail['vehicle_type'] == 'bike') ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>';}else{ echo 'NA';}?></td>
                </tr>
				<tr>
                    <td>GPS Tracking</td>
                    <td> : </td>
                    <td><?php echo (!empty($vehicle_detail['gps_device_serial'])) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php echo form_open("admin/hr-module/sanat-al-amar/submit", array("id" => "sanatCollectionForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Fill Detail</div>
	<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail['employee_id'];?>" required />
	<div class="row p-2">
		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="sanat_date">Sanat Date <span class="text-danger">*</span></label>
			<input type="date" class="form-control" id="sanat_date" name="sanat_date" max="<?php echo date('Y-m-d');?>" required />
		</div>

		<div class="col-md-6 col-sm-12 mb-3 form-group">
			<label for="sanat_no">Sanat No <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="sanat_no" name="sanat_no" minlength="16" maxlength="16" required />
		</div>
		
		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="sanat_amount">Sanat Amount <span class="text-danger">*</span></label>
			<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="sanat_amount" name="sanat_amount" required />
		</div>

		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="sanat_owner">Sanat Owner <span class="text-danger">*</span></label>
			<select name="sanat_owner" id="sanat_owner" class="form-select" required>
				<option value="">Select Owner</option>
				<option value="Abdulaziz Al Dhoheyan">Abdulaziz Al Dhoheyan</option>
				<option value="Itlubha International Company">Itlubha International Company</option>
			</select>
		</div>

		<div class="col-md-12 col-sm-12 mb-3 form-group">
			<label for="description">Description</label>
			<input type="text" class="form-control" id="description" name="description" maxlength="255" />
		</div>

		<div class="col-md-12 col-sm-12 mb-3 form-group">
			<input type="file" name="attachment" id="attachment" class="dropify"
				accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
				data-max-file-size="2M" data-height="100">
		</div>
	</div>
</div>

<?php echo form_close(); ?>

<script>
	$(document).ready(function() {
		$(".input-mask").inputmask();
		$('.dropify').dropify();
		$('#sanatCollectionForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/sanat-al-amar/submit');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						toastr.success(response.message);
						$('#searchResult').html('');
						$('#searchResponse').html('');
						$('#searchModalFooter').html('');
						initializeDataTable();
						$('#addCashModal').modal('hide');
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				}
			});
		});
	});

</script>
