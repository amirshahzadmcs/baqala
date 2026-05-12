<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Employee Detail</div>
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
                    <td>Iqama No</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['iqama_no'];?></td>
                </tr>
                <tr>
                    <td>Nationality</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['nationality_name'];?></td>
                </tr>
                <tr>
                    <td>Mobile No</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['mobile'];?></td>
                </tr>
                <tr>
                    <td>Vehicle No</td>
                    <td> : </td>
                    <td><?php if(!empty($vehicle_detail['vehicle_no'])){ echo $vehicle_detail['vehicle_no'];?> / <?php echo $vehicle_detail['vehicle_model'];?> / <?php echo $vehicle_detail['make_name'];?> <?php echo ($vehicle_detail['vehicle_type'] == 'bike') ? '<i class="fas fa-motorcycle font-size-20"></i>' : '<i class="mdi mdi-car font-size-20"></i>';}else{ echo 'NA';}?></td>
                </tr>
            </table>
            <!-- <div class="button mt-2 d-flex flex-row align-items-center">
                <button class="btn btn-sm btn-outline-primary w-100">Chat</button>
                <button class="btn btn-sm btn-primary w-100 ml-2">Follow</button>
            </div> -->
        </div>
    </div>
</div>
<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Fill DL Request Form</div>
    <?php echo form_open("admin/dl-request/submit", array("id" => "dlRequestForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
        <input type="hidden" id="emp_id" name="emp_id" value="<?php echo $emp_detail['id'];?>" required />
        <div class="row p-2">
            <div class="col-md-6 col-sm-12 mb-2 form-group">
                <label for="dl_type">Driving License Type <span class="text-danger">*</span></label>
                <select name="dl_type" id="dl_type" class="form-select" required>
                    <option value="">Choose DL Type</option>
                    <option value="bike">Bike</option>
                    <option value="car">Car</option>
					<option value="Nakal Khafif">Nakal Khafif</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-2 form-group">
                <label for="request_date">Request Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="request_date" name="request_date" max="<?php echo date("Y-m-d"); ?>" required />
            </div>
			
            <div class="col-md-12 col-sm-12 mb-2 form-group" id="expensesContainer">
                <label for="expenses_employee">Expenses by Employee <span class="text-danger">*</span></label>
                <div>
                <input type="checkbox" id="expenses" switch="bool" name="expenses_by_employee"><label for="expenses" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 mb-2 form-group">
                <label for="blood_group">Blood Group <span class="text-danger">*</span></label>
                <select name="blood_group" id="blood_group" class="form-select" required data-placeholder="Choose Blood group...">
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-2 form-group">
                <label for="newstatus">Status <span class="text-danger">*</span></label>
                <select name="status" id="newstatus" class="form-select" required>
                    <option value="">Choose Status</option>
                    <option value="Pending">Pending</option>
                    <option value="In Process">In Process</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <div class="col-md-12 col-sm-12 mb-3 form-group">
                <label for="reason">Reason</label>
                <textarea class="form-control" rows="2" id="reason" name="reason"></textarea>
            </div>
            
            <div class="col-md-12 col-sm-12 mb-3 form-group">
                <label for="dl_status">Add Attachment</label>
                <input type="file" name="attachment" id="attachment" class="dropify"
                    accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
                    data-max-file-size="2M" data-height="100">
            </div>
        </div>
    <?php echo form_close(); ?>
</div>
<script>
$(document).ready(function() {
	$('.dropify').dropify();
    // Trigger the change event initially to set the default state
    $('#expenses').trigger('change');
    
    $('#expenses').change(function(e) {
        e.preventDefault();
        $(".expensesChild").remove();
        var expenses_type = $(this).prop('checked'); // Get the checked state
        
        // Instead of checking for 'on', check if the switch is checked or not
        var iban_input = '';
        if(expenses_type){
            iban_input = `<div class="col-md-6 col-sm-12 mb-2 form-group expensesChild">
                    <label for="iban_no">IBAN No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="iban_no" name="iban_no" maxlength="35" value="<?php echo $iban_no;?>" required />
                </div>
                <div class="col-md-6 col-sm-12 mb-3 form-group expensesChild">
                    <label for="deduction_month">Deduction Month</label>
                    <div class="position-relative" id="datepicker4">
                        <input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" name="deduction_month" id="deduction_month" 
                        data-date-format="d MM yyyy" data-date-autoclose="true" data-date-min-view-mode="1" required>
                    </div>
                </div>`;
        }
        $("#expensesContainer").after(iban_input);
    });
});

$(document).ready(function() {
	$('#dlRequestForm').submit(function(e) {
		e.preventDefault();
		var formData = new FormData($(this)[0]);
		$.ajax({
			url: '<?php echo base_url('admin/dl-request/submit');?>',
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
					location.reload();
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
