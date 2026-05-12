<div>
    <?php echo form_open("admin/hr/employees/update-contract", array("id" => "contract_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
        <input type="hidden" name="emp_id" value="<?php echo $contract_info->employee_id;?>" required />
        <input type="hidden" name="id" value="<?php echo $contract_info->id;?>" required />
        <input type="hidden" name="redirect_path" value="<?php echo $redirect_path;?>" required />
        <!-- Tab panes -->
        <div id="ajaxRes"></div>
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="contract_type">Contract Type</label>
                <select class="form-control form-select" data-parsley-allselected="true" name="contract_type" id="contract_type" required>
                    <option value="">Select Contract Type</option>
                    <option value="Fix Term" <?php echo ($contract_info->contract_type == 'Fix Term') ? ' selected' : '' ?>>Fix Term</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="contract_duration">Contract Duration</label>
                <select class="form-control form-select" data-parsley-allselected="true" name="contract_duration" id="contract_duration" required>
                    <option value="">Select Contract Duration</option>
                    <option value="1" <?php echo ($contract_info->contract_duration == '1') ? ' selected' : '' ?>>1 Year</option>
                    <option value="2" <?php echo ($contract_info->contract_duration == '2') ? ' selected' : '' ?>>2 Year</option>
                    <option value="custom" <?php echo ($contract_info->contract_duration == 'custom') ? ' selected' : '' ?>>Custom</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="contract_start_date">Start Date (Gregorian)</label>
                <input type="date" class="form-control" id="contract_start_date" name="contract_start_date" value="<?php echo $contract_info->contract_start_date;?>" required />
            </div>
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="start_date_hijri">Start Date (Hijri)</label>
                <input type="date" class="form-control" id="start_date_hijri" name="start_date_hijri" value="<?php echo $contract_info->start_date_hijri;?>" readonly />
            </div>
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="contract_end_date">End Date (Gregorian)</label>
                <input type="date" class="form-control" id="contract_end_date" name="contract_end_date" value="<?php echo $contract_info->contract_end_date;?>" readonly />
            </div>
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="end_date_hijri">End Date (Hijri)</label>
                <input type="date" class="form-control" id="end_date_hijri" name="end_date_hijri" value="<?php echo $contract_info->end_date_hijri;?>" readonly />
            </div>
            <div class="col-md-12 col-sm-12 mb-3 form-group">
                <label for="is_probation_period">Did the Employee have a Probation Period?</label>
                <div>
                    <input class="form-check-input" type="radio" id="is_probation_period1" value="yes" name="is_probation_period" <?php echo ($contract_info->is_probation_period == 'yes') ? ' checked' : '' ?> style="vertical-align: top;margin-right: 3px;">
                    <label class="form-check-label" for="is_probation_period1">
                    Yes
                    </label>
                    <input class="form-check-input ms-3" type="radio" id="is_probation_period2" value="no" name="is_probation_period" <?php echo ($contract_info->is_probation_period == 'no') ? ' checked' : '' ?> style="vertical-align: top;margin-right: 3px;">
                    <label class="form-check-label" for="is_probation_period2">
                    No
                    </label>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-3 form-group probation_period <?php echo ($contract_info->is_probation_period == 'yes') ? ' ' : 'd-none' ?>">
                <label for="probation_days">Probation Period (Number of days)</label>
                <input type="text" class="form-control" id="probation_days" name="probation_days" value="<?php echo $contract_info->probation_days;?>" />
            </div>
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="contract_status">Contract Status</label>
                <select class="form-control form-select" data-parsley-allselected="true" name="contract_status" id="contract_status" required>
                    <option value="">Select Contract Status</option>
                    <?php foreach(contractStatusHelper() as $cstatus) { ?>
                        <option value="<?php echo $cstatus->id; ?>" <?php echo ($cstatus->id == $contract_info->contract_status) ? ' selected' : '' ?>><?php echo $cstatus->status_type; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12 col-sm-12 mb-3 form-group">
                <label for="attachment">Attachment</label>
                <input type="file" name="attachment" id="attachment" class="dropify"
                    accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
                    data-max-file-size="2M" data-height="100">
				<input type="hidden" name="old_attachment" value="<?php echo $contract_info->attachment;?>" />
            </div>
			<div class="col-md-12 col-sm-12 mb-3">
				<?php 
					if($contract_info->attachment !== ''){
						echo '<a href="'.base_url($contract_info->attachment).'" target="_blank"><i class="fas fa-paperclip"></i> '.substr($contract_info->attachment, 30, 50).'</a>';
					}else{
						echo 'NA';
					}
				?>
			</div>
        </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$('.dropify').dropify();

	$('#contract_duration').change(function() {
		var selectedDuration = $(this).val();
		if(selectedDuration == '1'){
			$('#contract_end_date').prop('readonly',true);
		} else if(selectedDuration == '2'){
			$('#contract_end_date').prop('readonly',true);
		}else{
			$('#contract_end_date').prop('readonly',false);
		}
		$("#contract_start_date").val('');
		$("#start_date_hijri").val('');
		$("#contract_end_date").val('');
		$("#end_date_hijri").val('');
	});

	$('#contract_start_date').change(function() {
		var contractStart = $(this).val();
		var input_duration = $('#contract_duration').val();
		if(input_duration == '1' || input_duration == '2' || input_duration == 'custom'){
			setDates(contractStart,input_duration);
		}else{
			$('#ajaxRes').html('<p class="text-danger">Select contract duration first.</p>');
		}
	});

	$('#contract_end_date').change(function() {
		var contractEnd = $(this).val();
		if(contractEnd !== ''){
			setEndDates(contractEnd);
		}
	});

	function setDates(contractStart,input_duration) {
		$("#start_date_hijri").val('');
		$("#contract_end_date").val('');
		$("#end_date_hijri").val('');
		var c_duration = '';
		if(input_duration == '1'){
			c_duration = 1;
		} else if(input_duration == '2'){
			c_duration = 2;
		}else{
			c_duration == 1;
			$('#contract_end_date').prop('readonly',false);
		}
		// End date
		var sDate = new Date(contractStart);
		// Add ten days to specified date
		sDate.setFullYear(sDate.getFullYear() + c_duration);
		var contractEnd = sDate.toISOString().slice(0,10);
		$('#contract_end_date').val(contractEnd);
		$.ajax({
			type: "GET",
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getHijriDate",
			data: {
				gregorian_date: contractStart
			},
			cache:false,
			success: function(res) {
				//console.log(res);
				$('#start_date_hijri').val(res);
			},
			complete:function(){
				$.ajax({
					type: "GET",
					url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getHijriDate",
					data: {
						gregorian_date: contractEnd
					},
					cache:false,
					success: function(res2) {
						//console.log(res2);
						$('#end_date_hijri').val(res2);
					},
				});
			},
			error: function(res){
				console.log(res);
			}
		});
	}

	function setEndDates(contractEnd) {
		$.ajax({
			type: "GET",
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getHijriDate",
			data: {
				gregorian_date: contractEnd
			},
			cache:false,
			success: function(res2) {
				//console.log(res2);
				$('#end_date_hijri').val(res2);
			},
			error: function(res){
				console.log(res);
			}
		});
	}

	$('input[type="radio"][name="is_probation_period"]').change(function() {
		$("#probation_days").val('');
		var checkedInput = $("input[type='radio'][name='is_probation_period']:checked").val();
		
		if(checkedInput == 'yes') {
			$('.probation_period').removeClass('d-none');
			$('#probation_days').prop('required',true);
		}else{
			$('.probation_period').addClass('d-none');
			$('#probation_days').prop('required',false);
		}    
	});
</script>
