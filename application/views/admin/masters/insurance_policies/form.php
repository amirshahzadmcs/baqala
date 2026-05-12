<div class="modal-header">
	<h5 class="modal-title mt-0">Edit Insurance Policies</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form data-parsley-validate="" id="insuranceForm" method="POST" action="<?php echo base_url('admin/master/insurance-policies/update');?>">
		<input type="hidden" id="id" name="id" value="<?php echo $detail->id;?>" required>
		<div class="row">
			<div class="col-md-12">
				<div class="mb-3">
					<label for="policy_type" class="form-label">Insurance Policy Type <span class="text-danger">*</span></label>
					<select class="form-select" name="policy_type" id="policy_type" required>
						<option value="">--- Select Policy Type ---</option>
						<option value="Vehicles" <?php echo ($detail->policy_type == 'Vehicles') ? "selected":"";?>>Vehicles</option>
						<option value="Employee" <?php echo ($detail->policy_type == 'Employee') ? "selected":"";?>>Employee</option>
					</select>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="policy_company" class="form-label">Insurance Policy Company <span class="text-danger">*</span></label>
					<select class="form-select" name="policy_company" id="policy_company" required>
						<option value="">--- Select Policy Company ---</option>
						<?php foreach($company_list as $ins_provider){ ?>
						<option value="<?php echo $ins_provider->id;?>" <?php echo ($detail->policy_company == $ins_provider->id) ? "selected":"";?>><?php echo $ins_provider->company_name;?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="policy_number" class="form-label">Insurance Policy Number <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="policy_number" name="policy_number" value="<?php echo $detail->policy_number;?>" required>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="policy_date" class="form-label">Insurance Policy Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" id="policy_date" name="policy_date" value="<?php echo $detail->policy_date;?>" required>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="policy_expiry" class="form-label">Insurance Policy Expiry <span class="text-danger">*</span></label>
					<input type="date" class="form-control" id="policy_expiry" name="policy_expiry" value="<?php echo $detail->policy_expiry;?>" required>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="policy_class" class="form-label">Select Class <span class="text-danger">*</span></label>
					<select id="policy_class" name="policy_class[]" class="form-select select2 select2-multiple" multiple required>
						<option value="">Select Class</option>
						<?php 
						if($detail->policy_class !=='' && $detail->policy_class !== NULL){
							$selected_classes = json_decode($detail->policy_class);
						}else{
							$selected_classes = '';
						}
						foreach (insuTypeHelper() as $mclass) { 
							if($detail->policy_class !=='' && $detail->policy_class !== NULL){
								$selected = in_array($mclass->id, $selected_classes) ? "selected" : "";
							}else{
								$selected = '';
							}
						?>
							<option value="<?php echo $mclass->id;?>" <?php echo $selected;?>><?php echo $mclass->insurance_type;?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Please provide a policies.
					</div>
				</div>
			</div>
			
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
	<button type="submit" form="insuranceForm" class="btn btn-success">Save</button>
</div>
<script>
	$('.select2').select2();
</script>
